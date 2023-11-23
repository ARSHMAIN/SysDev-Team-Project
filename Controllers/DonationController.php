<?php

class DonationController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "donation"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Donation/$action.php";
    }
}

?>