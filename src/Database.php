<?php
namespace Src;

class Database {
    private static $connection = null;

    public static function connect() {
        if (self::$connection === null) {
            self::$connection = new \PDO("sqlite:" . __DIR__ . "/../chat.db");
            self::$connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$connection;
    }
}
