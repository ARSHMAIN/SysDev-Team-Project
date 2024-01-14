<?php
class RegistrationController extends Controller
{
    function registration(): void
    {
        $this->render();
    }
    function register(): void
    {
        $postNamesAccepted = [
            "firstName",
            "lastName",
            "email",
            "password"
        ];

        $postNamesRequired = [
          "firstName",
          "lastName",
          "email",
          "password"
        ];

        $postDataAccepted = ValidationHelper::isPostDataAccepted($postNamesAccepted, $_POST);
        $postDataRequired = ValidationHelper::isPostDataRequired($postNamesRequired, $_POST);
        if($postDataAccepted && $postDataRequired) {


            User::createUserByRoleName($_POST);
            header("Location: index.php?controller=login&action=login");
        }
        else {
            ValidationHelper::shouldAddError(!$postDataRequired, "Invalid registration credentials");
            ValidationHelper::checkErrorExists(ErrorRedirectLocation::Registration->value);
        }
    }
}