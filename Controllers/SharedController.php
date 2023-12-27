<?php
include_once 'Core/Controller.php';
class SharedController extends Controller
{
    function error404(): void
    {
        $this->render();
    }
}