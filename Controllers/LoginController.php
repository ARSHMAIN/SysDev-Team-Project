<?php
include_once 'Views/Shared/session.php';
class LoginController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "login" || $action == "validation"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Login/$action.php";
    }
}

?>