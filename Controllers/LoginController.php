<?php
class LoginController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "login"){
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