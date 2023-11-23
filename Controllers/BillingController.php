<?php

class BillingController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "billing"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Billing/$action.php";
    }
}

?>