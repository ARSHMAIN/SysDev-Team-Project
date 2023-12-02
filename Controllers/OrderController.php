<?php
include_once 'database.php';
include_once 'Models/Snake.php';
include_once 'Models/Sex.php';
class OrderController
{
    function route(): void
    {
        global $action;
        if ($action == 'order') {
            $this->render($action);
        } else if ($action == 'test') {
            $this->render($action);
        } else if ($action == 'createTest') {
            $this->render($action);
        }
    }

    private function render(string $action, array $data = []): void
    {
        extract($data);
        include_once "Views/Order/$action.php";
    }
}