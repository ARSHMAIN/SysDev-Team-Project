<?php
include_once 'Views/Shared/session.php';
abstract class Controller
{
    abstract public function route(): void;
    public function render(array $data = []): void
    {
        global $controllerPrefix, $action;
        extract($data);
        include_once "Views/$controllerPrefix/$action.php";
    }
}