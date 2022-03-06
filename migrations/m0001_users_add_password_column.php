<?php

/**
 * m0002_add_password_column.php
 * User: kzoltan
 * Date: 2022-03-01
 * Time: 08:27
 */

class m0001_users_add_password_column
{
    public function up()
    {
        $db = \app\core\Application::$app->db;
        $query = "ALTER TABLE users 
            ADD COLUMN password VARCHAR(255) NOT NULL 
            AFTER email;";
        $db->pdo->exec($query);
    }
    
    public function down()
    {
        $db = \app\core\Application::$app->db;
        $query = "ALTER TABLE users DROP COLUMN password;";
        $db->pdo->exec($query);
    }
}