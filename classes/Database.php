<?php

// Database constants
define("DB_HOST", "localhost");
define("DB_USER", "root");
define("DB_PASSWORD", "");
define('DB_NAME', 'db_osas');

class Database
{
    private static $instance;
    private $connections;

    private function __construct()
    {
        $this->connections = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance->connections;
    }
}
