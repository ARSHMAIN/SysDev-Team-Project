<?php
include_once 'Views/Shared/session.php';
class FAQController
{
    function route(): void
    {
        global $controller, $action;
        if ($action == "faq"){
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/FAQ/$action.php";
    }
}

?>