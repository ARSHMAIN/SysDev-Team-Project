<?php

namespace MyApp\Controllers;

use Middleware\SessionMiddleware;
use MyApp\Models\User;
use Core\Controller;
use MyApp\Models\ValidationHelper;

class LoginController extends Controller
{
    function login(): void
    {
        SessionMiddleware::destroySession();
        $this->render();
    }

    function validation(): void
    {
        $postNamesAccepted = [
            "email",
            "password",
            "submit"
        ];

        $postNamesRequired = [
          "email",
          "password",
          "submit"
        ];

        $postDataAccepted = ValidationHelper::isPostDataAccepted($postNamesAccepted, $_POST);
        $postDataRequired = ValidationHelper::isPostDataRequired($postNamesRequired, $_POST);
        if ($postDataAccepted && $postDataRequired) {
            $validationResults = ValidationHelper::validateEmailAndPassword();

            // TODO: make logging off a separate action than landing on the login page
//            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::Login->value);

            $user = User::getUserByCredentials(
                $_POST['email'],
                md5($_POST['password']),
                "There was an error when logging in");
//            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::Login->value);
            if (!$user)  {
                header("Location: index.php?controller=login&action=login&error=incorrectCredentials");
                exit;
            }
            if (!$user->getRoleId()) {
                header("Location: index.php?controller=login&action=login");
                exit;
            }
            $_SESSION["userRole"] = $user->getRoleId();
            $_SESSION["user_id"] = $user->getUserId();
        }
        header("Location: index.php?controller=home&action=home");
    }
}