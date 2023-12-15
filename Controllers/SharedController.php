<?php

class SharedController
{
    function route(): void
    {
        global $action;
        if ($action == "error404") {
            $this->render($action);
        }
    }

    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Shared/$action.php";
    }
}