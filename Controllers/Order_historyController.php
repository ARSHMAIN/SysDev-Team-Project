<?php

class Order_historyController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "order_history"){ // TODO : rename as u wish
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/OrderHistory/$action.php";
    }
}

?>