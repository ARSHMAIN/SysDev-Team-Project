<?php
const BASE_CORE_DIR = 'app/config';
const BASE_MODELS_DIR = 'Models';
function autoloader($class): void
{
    $modelFilePath = BASE_MODELS_DIR . '/' . $class . '.php';
    $databaseFilePath = BASE_CORE_DIR . '/Database.php';
    if (file_exists($modelFilePath) && file_exists($databaseFilePath)) {
        require_once $databaseFilePath;
        require_once $modelFilePath;
    }
}
spl_autoload_register('autoloader');