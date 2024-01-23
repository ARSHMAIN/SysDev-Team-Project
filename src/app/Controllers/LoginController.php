<?php

namespace MyApp\Controllers;

use Middleware\SessionMiddleware;
use MyApp\Models\User;
use Core\Controller;

class LoginController extends Controller
{
    function login(): void
    {
        SessionMiddleware::destroySession();
        $this->render();
    }

    function validation(): void
    {
        if ($_POST['submit']) {
            $user = User::getUserByCredentials($_POST['email'], md5($_POST['password']));
            if (!$user) header("Location: index.php?controller=login&action=login&error=incorrectCredentials");
            if (!$user->getRoleId()) header("Location: index.php?controller=login&action=login");
            session_start();
            $_SESSION["userRole"] = $user->getRoleId();
            $_SESSION["user_id"] = $user->getUserId();
            header("Location: index.php?controller=home&action=home");
        } else {
            // this should be an error
            header("Location: index.php?controller=home&action=home");
        }
    }
}