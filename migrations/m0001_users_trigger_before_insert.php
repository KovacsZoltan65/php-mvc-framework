<?php
/**
 * Created by PhpStorm.
 * User: Selester
 * Date: 2022. 03. 05.
 * Time: 17:12
 */

class m0001_users_trigger_before_insert
{
	public function up()
	{
		$db = app\core\Application::$app->db;
		$query = "CREATE DEFINER = 'root'@'localhost'
			TRIGGER mvc_framework.users_BEFORE_INSERT
				BEFORE INSERT ON mvc_framework.users
				FOR EACH ROW
			BEGIN
				SET NEW.created_at = NOW();
				SET NEW.updated_at = NOW();
				SET NEW.uuid = UUID();
				SET NEW.checksum = md5(
					concat(
						NEW.name, NEW.password, NEW.email, NEW.status
					)
				);
			END;";
		$db->pdo->exec($query);
	}

	public function down()
	{
		$db = Application::$app->db;
		$query = "DROP TRIGGER mvc_framework.users_BEFORE_INSERT;";
		$db->pdo->exec($query);
	}
}