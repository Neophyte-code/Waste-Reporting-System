<?php

class Database
{

    private static $servername = 'localhost';
    private static $username = 'root';
    private static $dbname = 'waste_reporting_system';
    private static $password = '';
    private static $conn = null;

    public static function connect()
    {

        if (self::$conn === null) {
            try {
                self::$conn = new PDO("mysql:host=" . self::$servername . ";dbname=" . self::$dbname, self::$username, self::$password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo "Connection Failed: " . $e->getMessage();
            }
        }
        return self::$conn;
    }
}
