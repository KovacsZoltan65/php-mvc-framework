<?php
/**
 * Created by PhpStorm.
 * User: kzoltan
 * Date: 2022-03-05
 * Time: 16:17
 */

class m0002_companies_create
{
	public function up()
	{
		$db = \app\core\Application::$app->db;

		$query = "CREATE TABLE mvc_framework.companies (
            id int(11) NOT NULL AUTO_INCREMENT COMMENT 'Rekord azonosító',
            name varchar(50) NOT NULL COMMENT 'Cég neve',
            status tinyint(4) DEFAULT 0 COMMENT 'Státusz; 0 = aktív; 1 = inaktív; 2 =  törölt',
            uuid varchar(36) DEFAULT NULL COMMENT 'Globális azonosító',
            checksum varchar(32) DEFAULT NULL COMMENT 'Ellenörző összeg',
            created_at timestamp NOT NULL DEFAULT current_timestamp COMMENT 'Rekord létrehozása',
            updated_at timestamp NOT NULL DEFAULT current_timestamp COMMENT 'Utolsó frissítés',
            status_changed timestamp NULL DEFAULT NULL COMMENT 'Státusz váltás',
            syncronized_at timestamp NULL DEFAULT NULL COMMENT 'Utolró szinkronizálás',
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

		$query = "DROP TABLE mvc_framework.companies;";

		$db->pdo->exec($query);
	}
}