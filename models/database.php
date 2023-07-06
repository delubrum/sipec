<?php
require 'vendor/autoload.php';

class Database {
    public static function Conectar() {
        $dotenv = Dotenv\Dotenv::createUnsafeImmutable('/var/www/html/sipec/'); $dotenv->load();
        $dbUser = getenv('DB_USER');
        $dbPass = getenv('DB_PASS');
        $timezone = "America/Bogota";
        $pdo = new PDO("mysql:host=127.0.0.1;dbname=sipec;charset=utf8", "$dbUser", "$dbPass");
        $pdo->exec("SET time_zone = '{$timezone}'");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}