<?php
function openDatabaseConnection()
{
    $hostName = "localhost:3307";
    $userName = "root";
    $password = "";
    $dataBase = "snake";

    try {
        $conn = new PDO("mysql:host=$hostName;dbname=$dataBase;charset=utf8", $userName, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection Error: " . $e->getMessage());
    }

    return $conn;
}