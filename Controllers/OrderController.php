<?php
include_once 'Views/Shared/session.php';
include_once 'Models/User.php';
include_once 'Models/Snake.php';
include_once 'Models/Sex.php';
include_once 'Models/Morph.php';
include_once 'Models/KnownPossibleMorph.php';
include_once 'Models/CustomerSnakeName.php';
include_once 'Models/Test.php';
include_once 'Models/TestedMorph.php';
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