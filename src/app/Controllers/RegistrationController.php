<?php

namespace MyApp\Controllers;

use Core\Controller;
use MyApp\Models\User;

class RegistrationController extends Controller
{
    function registration(): void
    {
        $this->render();
    }

    function register(): void
    {
        User::createUserByRoleName($_POST);
        header("Location: index.php?controller=login&action=login");
    }
}