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

        <section class="loginRegisterWrapper marginAuto">
            <div class="textAlignCenter">
                <header class="loginRegisterHeader">
                    <label>
                        Register
                    </label>
                </header>
            </div>

            <form action="index.php?controller=registration&action=register" method="POST">
                <section>
                    <div class="loginRegisterInputLabelText registrationMargin widthMinContent marginAuto">
                        <div>
                            <label for="firstName">First Name</label> <span class="requiredAsterisk"> *</span>
                        </div>

                        <input id="email" type="text" name="firstName" class="width100Percent" >
                    </div>

                    <div class="loginRegisterInputLabelText registrationMargin widthMinContent marginAuto">
                        <div>
                            <label for="lastName">Last Name</label> <span class="requiredAsterisk"> *</span>
                        </div>

                        <input id="email" type="text" name="lastName" class="width100Percent" >
                    </div>

                    <div class="loginRegisterInputLabelText registrationMargin widthMinContent marginAuto">
                        <div>
                            <label for="email">Email</label> <span class="requiredAsterisk"> *</span>
                        </div>

                        <input id="email" type="text" name="email" class="width100Percent" >
                    </div>

                    <div class="loginRegisterInputLabelText registrationMargin widthMinContent marginAuto">
                        <div>
                            <label for="password">Password</label><span class="requiredAsterisk"> *</span>
                        </div>

                        <input id="password" type="password" name="password" class="width100Percent" >
                        <!--<div class="errorLabelText">
                            <label>Password is empty</label>
                        </div>-->
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