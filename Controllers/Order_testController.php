<?php

class Order_testController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "test"){ // TODO: rename as u wish
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/OrderTest/$action.php";
    }
}

?>