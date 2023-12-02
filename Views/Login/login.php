<?php
include_once 'Views/Shared/session.php';
session_unset();
session_destroy();
?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/login.css">
    </head>
    <body>
    <?php
        include_once 'Views/Shared/navbar.php';
    ?>

    <section class="loginWrapper marginAuto">
        <div class="loginRegisterHeader textAlignCenter">
            <header>
                <label>Login</label>
            </header>

            <form action="/?controller=login&action=validation" method="POST">
                <section>
                    <div>
                        <div class="loginRegisterInputLabelText textAlignStart widthMinContent marginAuto">
                            <div>
                                <label for="email">Email</label> <br/>
                            </div>

                            <input id="email" type="text" name="email" class="width100Percent" required><br>
                        </div>
                        <div class="loginRegisterInputLabelText textAlignStart widthMinContent marginAuto">
                            <div>
                                <label for="password">Password</label> <br/>
                            </div>
                            <input id="password" type="password" name="password" class="width100Percent" required> <br/>
                        </div>

                        <footer>
                            <div class="forgotPassword">
                                <a href="" >Forgot Password?</a>
                            </div>
                            <div class="signButtons widthMinContent marginAuto">
                                <div class="loginSignUpButton">
                                    <input type="submit" name="submit" class="cursorPointer width100Percent" value="Log in">
                                </div>

                                <div class="loginSignUpButton">
                                    <a href="">
                                        <input type="button" class="cursorPointer width100Percent" name="submit" value="Sign up">
                                    </a>
                                </div>
                            </div>
                        </footer>
                    </div>
                </section>
            </form>
        </div>
    </section>
    </body>
</html>