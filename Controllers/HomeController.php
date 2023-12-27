<?php
include_once 'Core/Controller.php';
class HomeController extends Controller
{
    function home(): void
    {
        $this->render();
    }
}
