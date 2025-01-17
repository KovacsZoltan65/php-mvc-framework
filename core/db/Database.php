<?php

/**
 * Database.php
 * User: kzoltan
 * Date: 2022-02-28
 * Time: 14:30
 */

namespace app\core\db;

use app\core\Application;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Description of Database
 *
 * @author kzoltan
 */
class Database 
{
    public PDO $pdo;
    
    /**
     * Adatbázis konstruktor.
     * Inicializálja a PDO kapcsolatot a mellékelt konfiguráció használatával.
     *
     * @param array $config Konfigurációs tömb 'dsn', 'user' és 'password' kulcsokkal.
     * @throws PDOException ha a kapcsolat meghiúsul.
     */
    public function __construct(array $config) 
    {
        $dsn = $config['dsn'] ?? '';
        $username = $config['user'] ?? '';
        $passwd = $config['password'] ?? '';
        
        $this->pdo = new PDO($dsn, $username, $passwd);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
    
    public function applySeeds()
    {
        $this->createSeedsTable();
        $appliedSeeds = $this->applySeeds();
        
        $newSeeds = [];
        $files = scandir(Application::$ROOT_DIR . '/seeds');
        
        $toApplySeeds = array_diff($files, $appliedSeeds);
        
        foreach($toApplySeeds as $seed) {
            if($seed === '.' || $seed === '..') {
                continue;
            }
            require_once Application::$ROOT_DIR . '/seeds/' . $seed;
            $className = pathinfo($seed, PATHINFO_FILENAME);
            
            $instance = new $className();
            $this->log("Applying seed $seed");
            $instance->up();
            $this->log("Applyed seed $seed");
            
            $newSeeds[] = $seed;
        }
        
        if( !empty($newSeeds) ) {
            $this->saveSeeds($newSeeds);
        } else {
            $this->log("All seeds are applied");
        }
    }
    
    /**
     * Lekéri az alkalmazott áttelepítések tömbjét az adatbázisból.
     *
     * @return array Alkalmazott áttelepítési nevek tömbje.
     */
    public function getAppliedMigrations(): array
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations;");
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getAppliedSeeds(): array
    {
        $statement = $this->pdo->prepare("SELECT seeds FROM seeds;");
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
    
    /**
     * Létrehozza a migrációk tábláját az adatbázisban, ha még nem létezik.
     */
    public function createMigrationsTable(): void
    {
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS mvc_framework.migrations (
            id int(11) NOT NULL AUTO_INCREMENT,
            migration varchar(255) DEFAULT NULL,
            created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
          )
          ENGINE = INNODB;");
    }
    
    public function createSeedsTable(): void
    {
        $this->pdo->exec(
            "CREATE TABLE IF NOT EXISTS mvc_framework.seeds (
            id int(11) NOT NULL AUTO_INCREMENT,
            seed varchar(255) DEFAULT NULL,
            created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
            )
            ENGINE = INNODB;"
        );
    }
    
    /**
     * Elmenti a megadott áttelepítési neveket az adatbázisban.
     *
     * @param array $migrations A megadott áttelepítési nevek tömbje.
     */
    public function saveMigrations(array $migrations): void
    {
        $str = implode(',', array_map(function($m) { return "('$m')"; }, $migrations));
        $query = "INSERT INTO migrations (migration) VALUES $str ;";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }
    
    public function saveSeeds(array $seeds): void
    {
        $str = implode(',', array_map(function($s) { return "('$s')"; }, $seeds));
        $query = "INSERT INTO seeds (seed) VALUES $str;";
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }
    
    /**
     * Készítsen nyilatkozatot a végrehajtáshoz.
     *
     * @param string $sql Az SQL előkészítése.
     *
     * @return PDOStatement Az elkészített nyilatkozat.
     */
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }
    
    protected function log(string $message): void
    {
        echo '['.date('Y-m-d H:i:s').'] - '.$message.PHP_EOL;
    }
    
}
