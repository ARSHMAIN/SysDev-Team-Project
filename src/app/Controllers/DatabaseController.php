<?php

namespace MyApp\Controllers;
use Core\Controller;

include_once 'Core/Controller.php';
include_once 'Database.php';

class DatabaseController extends Controller
{
    function index(): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SHOW TABLES FROM snake";
        $stmt = $dBConnection->query($sql);
        $tableNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (isset($_POST['database'])) {
            if ($_POST['database'] === 'order') {
                $_POST['database'] = '`order`';
            }
            $table = $this->table($_POST['database']);
            $this->render(['tableNames' => $tableNames, 'table' => $table]);
        }
        $this->render(['tableNames' => $tableNames]);
    }

    function table($pTableName): array
    {
        $dBConnection = openDatabaseConnection();
        $sql = "DESCRIBE $pTableName";
        $stmt = $dBConnection->query($sql);
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM $pTableName";
        $stmt = $dBConnection->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'columns' => $columns,
            'rows' => $rows,
        ];
    }
}