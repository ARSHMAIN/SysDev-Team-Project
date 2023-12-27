<?php
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