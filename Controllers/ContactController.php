<?php

class ContactController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "contact"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Contact/$action.php"; //
    }
}

?>