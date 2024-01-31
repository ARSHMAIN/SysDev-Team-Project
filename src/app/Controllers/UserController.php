<?php

namespace MyApp\Controllers;

use Core\Controller;

class UserController extends Controller
{
    function admin(): void
    {
        $this->render();
    }

    function editProfile() {
        $currentUser = new User($_SESSION["user_id"]);
        $userAddress = new Address(pUserId: $_SESSION["user_id"]);
        $this->render(
            [
                "user" => $currentUser,
                "address" => $userAddress
            ]
        );
    }

    function submitEditProfile() {
        $postNamesAccepted = [
            "firstName",
            "lastName",
            "phoneNumber",
            "companyName",
            "streetNumber",
            "streetName",
            "city",
            "stateOrRegion",
            "postalCode",
            "country",
            "submit"
        ];

        $postNamesRequired = [
            "firstName",
            "lastName",
            "streetNumber",
            "streetName",
            "city",
            "postalCode",
            "country",
            "submit"
        ];

        $postDataAccepted = ValidationHelper::isPostDataAccepted($postNamesAccepted, $_POST);
        $postDataRequired = ValidationHelper::isPostDataRequired($postNamesRequired, $_POST);

        if($postDataAccepted && $postDataRequired) {
            $editProfileValidationResults = ValidationHelper::validateEditProfileInformation();
            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::EditProfile->value);

            $updateUserInsensitiveInfoIsSuccessful = User::updateInsensitivePersonalInformation(
                $_SESSION["user_id"],
                $_POST,
                "An error occurred when updating your information"
            );
            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::EditProfile->value);

            $currentUserAddress = new Address(pUserId: $_SESSION["user_id"]);

            if($currentUserAddress->getAddressId() == -1) {
                $addressInsertionIsSuccessful = Address::createAddress(
                    $_SESSION["user_id"],
                    $_POST
                );
                // TODO: change temp. error message later
                ValidationHelper::shouldAddError(!$addressInsertionIsSuccessful, "A problem occurred when updating the address information (insertion)");
            }
            else {
                $addressUpdateIsSuccessful = Address::updateAddress(
                    $_SESSION["user_id"],
                    $_POST
                );
                // TODO: change temp. error message later
                ValidationHelper::shouldAddError(!$addressUpdateIsSuccessful, "A problem occurred when updating the address information (update)");
            }
            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::EditProfile->value);


            header("Location: " . ErrorRedirectLocation::EditProfile->value);
        }
        else {
            // TODO: temporary message, change error text later
            ValidationHelper::shouldAddError(true, "An error occurred when updating your information (not enough POST information)");
            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::EditProfile->value);
        }
    }
}