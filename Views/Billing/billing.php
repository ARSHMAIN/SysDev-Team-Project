<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Billing</title>
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

    <div>
        <form action="">
            <label for="firstName">First Name</label> </br> 
            <input type="text" id="firstName"> </br> 
            <label for="lastName">Last Name</label> </br> 
            <input type="text" id="lastName"> </br> 
            <input type="checkbox" name="company" id=""> 
            <label for="company">Company</label> </br> 
            <input type="text"> </br> 
            <label for="email">Email</label> </br> 
            <input type="email" id="email"> </br> 
            <label for="phoneNumber">Phone Number</label> </br> 
            <input type="text" id="phoneNumber"> </br> 
            <label for="mailingAddress">Mailing Address</label> </br> 
            <input type="text" id="mailingAddress">
        </form>
    </div>
</body>
</html>