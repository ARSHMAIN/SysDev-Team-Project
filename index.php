<?php
$controllerPrefix = isset($_GET["controller"]) ? $_GET["controller"] : "home";
$controllerName = ucfirst($controllerPrefix) . "Controller";


$action = isset($_GET["action"]) ? $_GET["action"] : "home";

include_once "Controllers/$controllerName.php";
$controller = new $controllerName;
$controller->route();
