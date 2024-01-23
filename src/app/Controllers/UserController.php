<?php

namespace MyApp\Controllers;

use Core\Controller;

class UserController extends Controller
{
    function admin(): void
    {
        $this->render();
    }
}