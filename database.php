<?php
function openDatabaseConnection() {
    $hostName = "localhost";
    $userName = "root";
    $password = "";
    $dataBase = "snake";

    $conn = new mysqli($hostName,$userName,$password,$dataBase);

    if ($conn->connect_error){
        die("Connection Error" . $conn->connect_error);
    }
    return $conn;
}
