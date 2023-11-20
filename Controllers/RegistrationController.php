<?php
class RegistrationController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "registration"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Register/$action.php";
    }
}