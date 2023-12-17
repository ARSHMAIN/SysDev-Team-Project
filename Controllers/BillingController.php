<?php
include_once 'Views/Shared/session.php';
include_once 'Models/User.php';
class BillingController
{
    function route(): void
    {
        global $action;
        $user = new User($_SESSION['user_id']);
        if ($action == "billing"){
            $this->render($action, ['user' => $user]);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Billing/$action.php";
    }
}
