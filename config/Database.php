<?php
namespace Config;

use PDO;
use PDOException;

class Database
{
    protected static function openDatabaseConnection()
    {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "snake";

        try {
            $conn = new PDO("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection Error: " . $e->getMessage());
        }

        return $conn;
    }
}
