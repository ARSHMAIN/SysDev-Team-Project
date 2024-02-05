<?php

namespace MyApp\Models;

use Config\Database;

class Admin extends Database
{
    public static function getSnakeTable()
    {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT COUNT(), first_name, last_name, sex_name, snake_origin FROM user u JOIN snake s on u.user_id=s.user_id JOIN sex sx on s.sex_id=sx=sex_id";
        } catch (\PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt?->closeCursor();
            $dBConnection = null;
        }
    }
}