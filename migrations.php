<?php

/**
 * migrations.php
 * User: kzoltan
 * Date: 2022-02-28
 * Time: 14:30
 */

use app\core\Application;
use Dotenv\Dotenv;
//use app\controllers\SiteController;
//use app\controllers\AuthController;

require_once __DIR__.'/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$config = [
    'user_class' => app\models\User::class,
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD'],
    ]
];

$app = new Application(__DIR__, $config);


$app->db->applyMigrations();