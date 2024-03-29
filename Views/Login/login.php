<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/loginRegister.css">
        <script src="Views/Shared/Scripts/textFieldValidation.js" type="text/javascript"></script>
        <script src="Views/Login/scripts/loginValidation.js" type="text/javascript"></script>
    </head>
    <body>
    <?php
        include_once 'Views/Shared/navbar.php';
    ?>

    <section class="loginRegisterWrapper marginAuto">
        <div>
            <?php
             if(isset($_SESSION["error"])) {
                    var_dump($_SESSION["error"]);
                }
            ?>

            <header class="loginRegisterHeader textAlignCenter">
                <label>Login</label>
            </header>

            <form id="login" action="index.php?controller=login&action=validation" method="POST">
                <section class="textAlignStart">
                        <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                            <div>
                                <label class="emailLabel" for="email">Email</label> <br/>
                            </div>

                            <input id="email" type="text" name="email" class="width100Percent">
                        </div>
                        <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                            <div>
                                <label class="passwordLabel" for="password">Password</label> <br/>
                            </div>
                            <input id="password" type="password" name="password" class="width100Percent">
                        </div>

                        <footer>
                            <div class="forgotPassword textAlignCenter">
                                <a href="" >Forgot Password?</a>
                            </div>
                            <div class="signButtons widthMinContent marginAuto">
                                <div class="loginSignUpButton">
                                    <input type="submit" name="submit" class="cursorPointer width100Percent" value="Log in">
                                </div>

                                <div class="loginSignUpButton">
                                    <a href="/?controller=registration&action=registration">
                                        <input type="button" class="cursorPointer width100Percent" name="submit" value="Sign up">
                                    </a>
                                </div>
                            </div>
                        </footer>
                </section>
            </form>
        </div>
    </section>
    </body>
</html>