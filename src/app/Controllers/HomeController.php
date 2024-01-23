<?php

namespace MyApp\Controllers;

use Core\Controller;

class HomeController extends Controller
{
    function home(): void
    {
        $this->render();
    }
}
