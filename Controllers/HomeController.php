<?php

class HomeController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "home"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Home/$action.php";
    }
}