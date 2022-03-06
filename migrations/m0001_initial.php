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
				id              int(11)         NOT NULL AUTO_INCREMENT,
				name            varchar(255)    NOT NULL COMMENT 'Megnevezés',
				status          tinyint(4)      NOT NULL DEFAULT 0 COMMENT 'Státusz; 0 = aktív; 1 = inaktív; 2 =  törölt',
				uuid            varchar(36)     DEFAULT NULL COMMENT 'Globális azonosító',
				checksum        varchar(32)     DEFAULT NULL COMMENT 'Ellenörző összeg',
				created_at      timestamp       NULL DEFAULT current_timestamp COMMENT 'Rekord készült',
				updated_at      timestamp       NULL DEFAULT current_timestamp COMMENT 'Utolsó frissítés',
				status_changed  timestamp       NULL DEFAULT NULL COMMENT 'Státuszváltás dátuma',
				syncronized_at  timestamp       NULL DEFAULT NULL COMMENT 'Szinkronizálás dátuma',
				PRIMARY KEY (id)
			)
			ENGINE = INNODB,
			CHARACTER SET utf8,
			COLLATE utf8_general_ci;";

        $db->pdo->exec($query);
    }
    
    public function down()
    {
        $db = \app\core\Application::$app->db;
        
        $query = "DROP TABLE mvc_framework.users;";
        
        $db->pdo->exec($query);
    }
}