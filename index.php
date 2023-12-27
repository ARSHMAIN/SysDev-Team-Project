<?php
$controllerPrefix = $_GET["controller"] ?? "home";
$controllerName = ucfirst($controllerPrefix) . "Controller";

$action = $_GET["action"] ?? "home";

if (file_exists("Controllers/$controllerName.php"))
{
    // Parent Controller included into each individual Controller
    include_once 'Core/Controller.php';
    include_once "Controllers/$controllerName.php";
}
else
{   
    include_once "Views/Shared/error404.php";
}

$controller = new $controllerName;
Controller::loadAuthentication();
include_once 'autoloader.php';
$controller->$action();
