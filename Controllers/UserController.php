<?php



class UserController extends Controller
{
    function admin(): void
    {
        $this->render();
    }

    function editProfile(): void
    {
        $currentUser = new User($_SESSION["user_id"]);
        $userAddress = new Address(pUserId: $_SESSION["user_id"]);
        $this->render(
            [
                "user" => $currentUser,
                "address" => $userAddress
            ]
        );
    }

    function submitEditProfile(): void
    {
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
            ValidationHelper::checkSessionErrorExists(RedirectLocation::EditProfile->value);

            $updateUserInsensitiveInfoIsSuccessful = User::updateInsensitivePersonalInformation(
                $_SESSION["user_id"],
                $_POST,
                true,
                "An error occurred when updating your information"
            );
            ValidationHelper::checkSessionErrorExists(RedirectLocation::EditProfile->value);

            $currentUserAddress = new Address(pUserId: $_SESSION["user_id"]);


            // If there is no address associated with the current user, create a new address
            // Otherwise update the current address associated with the user
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
            ValidationHelper::checkSessionErrorExists(RedirectLocation::EditProfile->value);


            header("Location: " . RedirectLocation::EditProfile->value);
        }
        else {
            // TODO: temporary message, change error text later
            ValidationHelper::shouldAddError(true, "An error occurred when updating your information (not enough POST information)");
            ValidationHelper::checkSessionErrorExists(RedirectLocation::EditProfile->value);
        }
    }

    function editEmail(): void
    {
        $this->render();
    }

    function submitEditEmail(): void
    {
        $postNamesAccepted = [
            "newEmailAddress",
            "password",
            "submit"
        ];

        $postNamesRequired = [
            "newEmailAddress",
            "password",
            "submit"
        ];

        $postDataAccepted = ValidationHelper::isPostDataAccepted($postNamesAccepted, $_POST);
        $postDataRequired = ValidationHelper::isPostDataRequired($postNamesRequired, $_POST);

        if($postDataAccepted && $postDataRequired) {
            $editEmailValidationResults = ValidationHelper::validateEditEmailInformation();
            ValidationHelper::checkSessionErrorExists(RedirectLocation::EditEmail->value);


            $generatedRandomToken = EmailVerificationToken::generateEmailVerificationHash(
                true,
                "An error occurred when starting the change email process"
            );
            ValidationHelper::checkSessionErrorExists(RedirectLocation::EditEmail->value);


            $thirtyMinutesInSeconds = 60 * 30;
            $expiryDate = EmailVerificationToken::generateExpiryDate($thirtyMinutesInSeconds);

            $emailVerificationTokenInsertionResults = EmailVerificationToken::createIfNotExists(
                $_SESSION["user_id"],
                $generatedRandomToken,
                $expiryDate,
                $_POST["newEmailAddress"],
                false
            );
            $emailVerificationTokenIsSuccessful = $emailVerificationTokenInsertionResults["isSuccessful"];
            $emailVerificationToken = $emailVerificationTokenInsertionResults["emailVerificationToken"];
            // TODO: refactor the send email code to a function
            if($emailVerificationTokenIsSuccessful) {
                try {
                    // Send an email to the new email address' inbox because we want to verify whether the
                    // user should be able to change email addresses for their account
                    $emailHelper = new EmailHelper(true);
                    $emailHelper->isHTML(true)
                        ->setFrom("noreplysnake@gmail.com", "Snake Genotype Testing")
                        ->addAddress($_POST["newEmailAddress"])
                        ->subject("Change your Snake Genotype Testing email")
                        ->body(<<<END
                            Click <a href="localhost/?controller=user&action=verifyEmailChange&token=$generatedRandomToken">here</a> to verify your email address change.
                        END)
                        ->send();


                    $currentUser = new User($_SESSION["user_id"]);
                    $emailHelper->clearAllRecipients();
                    $contactRedirectLocation = RedirectLocation::Contact->value;
                    $emailHelper->subject("Request to change your email address")
                        ->body(<<<END
                            Hello {$currentUser->getFirstName()}, <br/>
                            We received a request to change your email address for your account from {$currentUser->getEmail()} to {$emailVerificationToken->getNewEmail()}. <br/>
                            Please make sure that this request is coming from you. <br/>
                            If not, please contact us <a href="localhost/{$contactRedirectLocation}">here</a>.
                        END)
                        ->addAddress($currentUser->getEmail())
                        ->send();

                }
                catch(Exception $e) {
                    ValidationHelper::shouldAddError(true, "Email could not be sent to the email address specified");
                    ValidationHelper::checkSessionErrorExists(RedirectLocation::EditEmail->value);
                }
            }

            // Success message will be output even when there is already the same email in the system (database) for security reasons
            ValidationHelper::shouldAddSuccess(true, "An email with further instructions has been sent to your email inbox");
            ValidationHelper::checkSessionSuccessExists(RedirectLocation::EditEmail->value);
        }
        else {
            ValidationHelper::shouldAddError(true, "Please type your current password and the new email address for your account.");
            ValidationHelper::checkSessionErrorExists(RedirectLocation::EditEmail->value);
        }
    }

    function verifyEmailChange(): void
    {
        $token = $_GET["token"] ?? "";
        $emailVerificationTokenQueryResults = EmailVerificationToken::getByResetEmailHash(
            $token,
            true,
            "An error occurred when verifying the new email address"
        );
        $userDoesNotExist = false;
        $verificationLinkExpired = false;
        $invalidEmail = false;
        $canChangeEmail = false;


        if($emailVerificationTokenQueryResults["emailVerificationToken"]->getUserId() == -1) {
            $userDoesNotExist = true;
        }
        else if(strtotime($emailVerificationTokenQueryResults["emailVerificationToken"]->getResetEmailHashExpiresAt()) <= time()) {
            $verificationLinkExpired = true;
        }
        else if($emailVerificationTokenQueryResults["isSuccessful"]
            && (($emailVerificationTokenQueryResults["emailVerificationToken"]->getNewEmail() == null)
                || (mb_strlen($emailVerificationTokenQueryResults["emailVerificationToken"]->getNewEmail(), "UTF-8") == 0))
        ) {
            // If the email is empty or null, tell the user that the email could not be changed for their account
            $invalidEmail = true;
        }
        else if($emailVerificationTokenQueryResults["isSuccessful"]){
            $canChangeEmail = true;
            $user = new User($emailVerificationTokenQueryResults["emailVerificationToken"]->getUserId());
            $oldEmail = $user->getEmail();
            $newEmail = $emailVerificationTokenQueryResults["emailVerificationToken"]->getNewEmail();

            $userChangeEmailIsSuccessful = User::changeEmailByUserId(
                $emailVerificationTokenQueryResults["emailVerificationToken"]->getUserId(),
                $emailVerificationTokenQueryResults["emailVerificationToken"]->getNewEmail(),
                true,
                "An error occurred when changing the email address"
            );

//            ValidationHelper::shouldAddError();
            EmailVerificationToken::updateRowByUserId(
                $emailVerificationTokenQueryResults["emailVerificationToken"]->getUserId(),
                null,
                null,
                null,
                true,
                "An error occurred when changing the email address"
            );


            try {

                $emailHelper = new EmailHelper(true);
                $contactRedirectLocation = RedirectLocation::Contact->value;
                $emailHelper->isHTML(true)
                    ->setFrom("noreplysnake@gmail.com", "Snake Genotype Testing")
                    ->addAddress($user->getEmail())
                    ->subject("Email change")
                    ->body(<<<END
                        Hello {$user->getFirstName()}, <br/>
                        Your account's email address has been changed from "{$oldEmail}" to "{$newEmail}". <br/>
                        Contact us <a href="localhost/{$contactRedirectLocation}">here</a> if this change was not made by you.
                    END)
                    ->send();
            }
            catch(Exception $e) {
                ValidationHelper::shouldAddError(true, "Email could not be sent to the address specified");
                ValidationHelper::checkSessionErrorExists(RedirectLocation::EditEmail->value);
            }
        }

        $this->render(
            [
                "userDoesNotExist" => $userDoesNotExist,
                "verificationLinkExpired" => $verificationLinkExpired,
                "invalidEmail" => $invalidEmail,
                "canChangeEmail" => $canChangeEmail
            ]
        );
    }

    function editPassword() {

    }

    function submitEditPassword() {

    }
}