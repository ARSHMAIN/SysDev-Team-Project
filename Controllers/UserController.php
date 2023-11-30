<?php
class UserController
{
    function route(): void
    {
        global $action;
        if ($action == "admin") {
            $this->render($action);
        }
    }

    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/User/$action.php";
    }
}