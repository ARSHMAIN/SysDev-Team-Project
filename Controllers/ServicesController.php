<?php

class ServicesController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "services"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Services/$action.php";
    }
}

?>