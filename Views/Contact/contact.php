<?php
//include_once "Views/Shared/session.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
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
    <div class="padding">
    <h2>Contact Us</h2>

    <form action="index.php?controller=contact&action=email" method="post" class="input_figma_styling padding">
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
    </div>
</body>
</html>