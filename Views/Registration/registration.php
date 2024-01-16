<html>
    <head>
        <meta charset="UTF-8">
        <title>Register</title>
        <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/loginRegister.css">
        <script src="Views/Shared/Scripts/textFieldValidation.js" type="text/javascript"></script>
        <script src="Views/Registration/scripts/registrationValidation.js" type="text/javascript"></script>
    </head>

    <body>
        <?php
            include_once "Views/Shared/navbar.php";
        ?>

        <div>
            <?php
                if(isset($_SESSION["error"])) {
                    var_dump($_SESSION["error"]);
                }
            ?>
        </div>
        <section class="loginRegisterWrapper marginAuto">
            <div class="textAlignCenter">
                <header class="loginRegisterHeader">
                    <label>
                        Register
                    </label>
                </header>
            </div>

            <form id="registration" action="index.php?controller=registration&action=register" method="POST">
                <section>
                    <div class="loginRegisterInputLabelText registrationMargin widthMinContent marginAuto">
                        <div>
                            <label class="firstNameLabel" for="firstName">First Name <span class="requiredAsterisk"> *</span></label>
                        </div>

                        <input id="email" type="text" name="firstName" class="width100Percent" >
                    </div>

                    <div class="loginRegisterInputLabelText registrationMargin widthMinContent marginAuto">
                        <div>
                            <label class="lastNameLabel" for="lastName">Last Name <span class="requiredAsterisk"> *</span></label>
                        </div>

                        <input id="email" type="text" name="lastName" class="width100Percent" >
                    </div>

                    <div class="loginRegisterInputLabelText registrationMargin widthMinContent marginAuto">
                        <div>
                            <label class="emailLabel" for="email">Email<span class="requiredAsterisk"> *</span></label>
                        </div>

                        <input id="email" type="text" name="email" class="width100Percent" >
                    </div>

                    <div class="loginRegisterInputLabelText registrationMargin widthMinContent marginAuto">
                        <div>
                            <label class="passwordLabel" for="password">Password<span class="requiredAsterisk"> *</span></label>
                        </div>

                        <input id="password" type="password" name="password" class="width100Percent" >
                    </div>



                    <footer>
                        <section class="signButtons marginAuto">
                            <div class="loginSignUpButton">
                                <input type="submit" name="submit" class="cursorPointer width100Percent" value="Sign up">
                            </div>
                        </section>
                    </footer>
                </section>
            </form>
        </section>
    </body>
</html>