<?php

namespace MyApp\Controllers;

use Core\Controller;

class SharedController extends Controller
{
    function error404(): void
    {
        $this->render();
    }
}