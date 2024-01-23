<?php
namespace Core;

use Middleware\SessionMiddleware;

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
        include_once "src/app/Views/$controllerPrefix/$action.php";
    }

}