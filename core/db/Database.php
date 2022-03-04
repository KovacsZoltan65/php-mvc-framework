<?php

/**
 * Database.php
 * User: kzoltan
 * Date: 2022-02-28
 * Time: 14:30
 */

namespace app\core\db;

use app\core\Application;

/**
 * Description of Database
 *
 * @author kzoltan
 */
class Database 
{
    public \PDO $pdo;
    
    public function __construct(array $config) 
    {
        $dsn = $config['dsn'] ?? '';
        $username = $config['user'] ?? '';
        $passwd = $config['password'] ?? '';
        
        $this->pdo = new \PDO($dsn, $username, $passwd);
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }
    
    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        
        $newMigrations = [];
        
        $files = scandir(Application::$ROOT_DIR.'/migrations');
        
        $toApplyMigrations = array_diff($files, $appliedMigrations);
        
        foreach($toApplyMigrations as $migration)
        {
            if($migration === '.' || $migration === '..')
            {
                continue;
            }
            require_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applyed migration $migration");
            
            $newMigrations[] = $migration;
        }
        
        if( !empty($newMigrations) )
        {
            $this->saveMigrations($newMigrations);
        }
        else
        {
            $this->log("All migrations are applied");
        }
    }
    
    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations;");
        $statement->execute();
        
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }
    
    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS mvc_framework.migrations (
            id int(11) NOT NULL AUTO_INCREMENT,
            migration varchar(255) DEFAULT NULL,
            created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
          )
          ENGINE = INNODB;");
    }
    
    public function saveMigrations(array $migrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $query = "INSERT INTO migrations (migration) VALUES $str ;";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }
    
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
    
    protected function log(string $message)
    {
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }
    
}
