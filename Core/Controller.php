<?php
include_once 'Middleware/SessionMiddleware.php';
class Controller
{
    public function __construct()
    {
        SessionMiddleware::initializeSession();
    }

    protected function render(array $data = []): void
    {
        global $controllerPrefix, $action;
        extract($data);
        include_once "Views/$controllerPrefix/$action.php";
    }

}