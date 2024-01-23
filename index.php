<?php
require_once 'vendor/autoload.php';

$controllerPrefix = $_GET["controller"] ?? "home";
$controllerName = ucfirst($controllerPrefix) . "Controller";

$action = $_GET["action"] ?? "home";

$controllerClass = "MyApp\\Controllers\\$controllerName";

if (class_exists($controllerClass)) {
    $controller = new $controllerClass();
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        include_once "src/app/Views/Shared/error404.php";
    }
} else {
    include_once "src/app/Views/Shared/error404.php";
}
