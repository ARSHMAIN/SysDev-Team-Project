<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/contact.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/home.css">
    <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>
    <script src="Views/Shared/Scripts/toggleGender.js" defer></script>
    <script src="Views/Shared/Scripts/searchDropdown.js" defer></script>
    <script src="Views/Home/orderTest.js" defer></script>
</head>

<body>
    <?php
    include_once 'Views/Shared/navbar.php';
    ?>
    <div class="">
        <h2>Contact Us</h2>
        <form action="?controller=contact&action=email" method="post" class="input_figma_styling">
            <div class="loginRegisterWrapper textAlignStart">
                <form action="?controller=billing&action=review" method="post">
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="name">Name</label> </br>
                        </div>
                        <input type="text" name="name" id="name">
                        </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="email">Email</label> </br>
                        </div>
                        <input type="email" name="email" id="email">
                        </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="subject">Subject</label> </br>
                        </div>
                        <input type="subject" name="subject" id="subject"> </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="inquiry">Inquiry</label> </br>
                        </div>
                        <textarea style="font-size: large;" name="inquiry" id="inquiry" cols="30" rows="10"></textarea><br>
                        </br>
                    </div>
                    <div class="signButtons widthMinContent marginAuto">
                        <div class="loginSignUpButton">
                            <input style="color: black; font-size: large;" type="submit" name="submit"
                                class="cursorPointer width100Percent" value="Submit">
                        </div>
                    </div>
            </div>
        </form>
        <!--
            <label for="name">Your name</label><br>
            <input type="text" name="name" id="name"> <br>
            <label for="email">Your email address</label><br>
            <input type="text" name="email" id="email"> <br>
            <label for="subject">Your subject</label><br>
            <input type="text" name="subject" id="subject"> <br>
            <label for="inquiry">Inquiry</label><br>
            <textarea name="inquiry" id="inquiry" cols="53.5" rows="10"></textarea><br>
            <input type="submit" name="submit" value="Contact Us">
        </form>
-->
    </div>
</body>

</html>