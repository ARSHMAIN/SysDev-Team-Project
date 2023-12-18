<?php
include_once 'Views/Shared/session.php';
class ContactController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "contact"){
            $this->render($action);
        } else if ($action == "email") {
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Contact/$action.php";
    }
}
