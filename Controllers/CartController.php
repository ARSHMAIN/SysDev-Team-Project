<?php

class CartController
{
    function route(): void
    {
        global $action;
        if ($action == "cart") {
            $this->render($action);
        }
    }

    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Cart/$action.php";
    }
}