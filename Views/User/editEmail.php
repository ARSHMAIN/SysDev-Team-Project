<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Email</title>
        <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
        <script src="Views/Shared/Scripts/textFieldValidation.js" defer></script>
        <script src="Views/User/Scripts/editEmail.js" defer></script>
    </head>

    <body>
        <?php
            include_once "Views/Shared/navbar.php";
        ?>

        <main>
            <?php
                // If a "success" key exists in the session superglobal, don't print the error for security reasons:
                // we don't want the error to see whether a certain email address exists in the system
                if(array_key_exists("success", $_SESSION)) {
                    var_dump($_SESSION["success"]);
                }
                else if(array_key_exists("error", $_SESSION)) {
                    var_dump($_SESSION["error"]);
                }
            ?>
            <form action="?controller=user&action=submitEditEmail" method="POST" class="editEmail">
                <div class="textAlignCenter">
                    <h1>
                        Edit Email:
                    </h1>
                    <div>
                        <div>
                            <label class="newEmailAddressLabel" for="newEmailAddress">
                                New email address:
                            </label>
                        </div>

                        <div>
                            <input type="text" name="newEmailAddress">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label class="passwordLabel" for="password">
                                Password:
                            </label>
                        </div>

                        <div>
                            <input type="password" name="password">
                        </div>
                    </div>

                    <div>
                        <input type="submit" name="submit">
                    </div>
                </div>
            </form>
        </main>
    </body>
</html>

<?php
    unset($_SESSION["error"]);
    unset($_SESSION["success"]);
?>