<?php
$controllerPrefix = $_GET["controller"] ?? "home";
$controllerName = ucfirst($controllerPrefix) . "Controller";

$action = $_GET["action"] ?? "home";

if (file_exists("Controllers/$controllerName.php"))
{
    include_once "Controllers/$controllerName.php";
}
else
{   
    include_once "Views/Shared/error404.php";
}

$controller = new $controllerName;
Controller::loadAuthentication();
$controller->$action();
