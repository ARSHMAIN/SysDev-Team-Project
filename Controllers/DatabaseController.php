<?php
include_once 'Views/Shared/session.php';
include_once 'database.php';
class DatabaseController
{
    function route(): void
    {
        global $action;
        if ($action == "index"){
            $dBConnection = openDatabaseConnection();
            $sql = "SHOW TABLES FROM snake";
            $stmt = $dBConnection->query($sql);
            $tableNames = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (isset($_POST['database'])) {
                if ($_POST['database'] === 'order') {
                    $_POST['database'] = '`order`';
                }
                $table = $this->table($_POST['database']);
                $this->render($action, ['tableNames' => $tableNames, 'table' => $table]);
            }
            $this->render($action, ['tableNames' => $tableNames]);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Database/$action.php";
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