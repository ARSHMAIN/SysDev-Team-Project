<?php
include_once 'Views/Shared/session.php';
include_once "Models/User.php";
class RegistrationController
{
    function route(): void
    {
        global $controller, $action;

        if ($action == "registration" || $action == "register"){
            $this->render($action);
        }

    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Register/$action.php";
    }
}

?>