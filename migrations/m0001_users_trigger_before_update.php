<?php
/**
 * Created by PhpStorm.
 * User: Selester
 * Date: 2022. 03. 05.
 * Time: 17:26
 */

class m0002__users_trigger_before_update
{
	public function up()
	{
		$db = Application::$app->db;
		$query = "CREATE DEFINER = 'root'@'localhost'
            TRIGGER mvc_framework.users_BEFORE_UPDATE BEFORE UPDATE
                ON mvc_framework.users
                FOR EACH ROW
            BEGIN

                IF ( OLD.status <> NEW.status ) THEN
                    SET NEW.status_changed = NOW();
                END IF;

                SET NEW.checksum = MD5(
                  CONCAT(
                    NEW.email, NEW.password, NEW.first_name, NEW.last_name, NEW.status
                  )
                );
                IF ( OLD.checksum <> @new_checksum ) THEN
                    SET NEW.updated_at = NOW();
                    SET NEW.checksum = @new_checksum;
                END IF;
            END";
		$db->pdo->exec($query);
	}

	public function down()
	{
		$db = Application::$app->db;
		$query = "DROP TRIGGER mvc_framework.users_BEFORE_UPDATE;";
		$db->pdo->exec($query);
	}
}