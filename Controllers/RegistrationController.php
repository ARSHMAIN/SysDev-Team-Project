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
            "password",
            "submit"
        ];

        $postNamesRequired = [
          "firstName",
          "lastName",
          "email",
          "password",
            "submit"
        ];

        $postDataAccepted = ValidationHelper::isPostDataAccepted($postNamesAccepted, $_POST);
        $postDataRequired = ValidationHelper::isPostDataRequired($postNamesRequired, $_POST);
        if($postDataAccepted && $postDataRequired) {
            // Temporary measure to clear out the session error to give the correct error message
            $_SESSION["error"] = null;
            ValidationHelper::validateFirstNameAndLastName();
            ValidationHelper::validateEmailAndPassword();
            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::Registration->value);


            // If the validation passed, create the user
            // because the credentials are correct
            User::createUserByRoleName($_POST, "There was an error when creating the account");
            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::Registration->value);

            header("Location: index.php?controller=login&action=login");
        }
        else {
            ValidationHelper::shouldAddError(!$postDataRequired, "Invalid registration credentials");
            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::Registration->value);
        }
    }
}