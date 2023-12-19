<?php
include_once 'Views/Shared/session.php';
include_once 'Models/Order.php';
include_once 'Models/OrderStatus.php';
class HistoryController
{
    function route(): void
    {
        global $action;
        if ($action == "history"){
            $order = Order::getOrderByUserId($_SESSION['user_id']);
            $this->render($action, ['order' => $order]);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/History/$action.php";
    }
}