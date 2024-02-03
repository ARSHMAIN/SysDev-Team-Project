<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Verify Email Change</title>
        <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
    </head>

    <body>
        <?php
            include_once "Views/Shared/navbar.php";
        ?>

        <main>
            <?php
                if(array_key_exists("error", $_SESSION)) {
                    var_dump($_SESSION["error"]);
                }
                else if($data["userDoesNotExist"]) {
                    header("Location: " . RedirectLocation::Home->value);
                    exit;
                }
                else if($data["verificationLinkExpired"]) {
                    echo <<<END
                        <div class="textAlignCenter">
                            <label>The verification link has expired</label>
                        </div>
                    END;
                }
                else if($data["invalidEmail"]) {
                    // If the email is empty or null, tell the user that the email could not be changed for their account
                    echo <<<END
                        <div class="textAlignCenter">
                            <label>An error occurred when changing the email for your account</label>
                        </div>
                    END;
                }
                else if($data["canChangeEmail"]) {
                    echo <<<END
                        <div class="textAlignCenter">
                            <label>Your email address has been changed! An email to your old email address' inbox has been sent informing of the change.</label>
                        </div>
                    END;
                }
            ?>
        </main>
    </body>
</html>