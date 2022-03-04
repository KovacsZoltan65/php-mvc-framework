<?php

/**
 * m0001_initial.php
 * User: kzoltan
 * Date: 2022-02-28
 * Time: 14:30
 */

class m0001_initial
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        
        $query = "CREATE TABLE mvc_framework.users (
            id int(11) NOT NULL AUTO_INCREMENT,
            email varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            first_name varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            last_name varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
            status tinyint(4) NOT NULL,
            created_at timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
          )
          ENGINE = INNODB;";
        
        $db->pdo->exec($query);
    }
    
    public function down()
    {
        $db = \app\core\Application::$app->db;
        
        $query = "DROP TABLE mvc_framework.users;";
        
        $db->pdo->exec($query);
    }
}