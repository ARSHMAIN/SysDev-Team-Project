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
    </hr>

    <form action="">
        <label for="email">Your email address</label> </br>
        <input type="text" id="email"> </br> 
        <label for="inquiry">Inquiry</label>
        <br>
        <textarea name="inquiry" id="inquiry" cols="30" rows="10" placeholder="inquiry">
        </textarea> </br>
        <button type="submit">Contact Us</button>
    </form>
    </div>
    
</body>
</html>