<?php

class Admin_panelController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "admin"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Admin/$action.php";
    }
}

?>