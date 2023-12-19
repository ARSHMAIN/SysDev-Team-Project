<?php
include_once 'Views/Shared/session.php';
class DatabaseController
{
    function route(): void
    {
        global $action;
        if ($action == "index"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Database/$action.php";
    }
}