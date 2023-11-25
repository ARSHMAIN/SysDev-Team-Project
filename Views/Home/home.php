<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
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
<form id="order" name="order"  method="post">
    <img id="addBtn" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="removeSign">
    <img id="removeBtn" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign">
    <input id="morph1" type="text" name="morph1">
    <input id="morph2" type="text" name="morph2">
    <input id="submit" type="submit" name="submit">
</form>
<form id="sex" name="sex"  method="post">
    <img id="maleGender" class="gender" src="Views/Images/maleGender.png" alt="maleGender">
    <img id="femaleGender" class="gender" src="Views/Images/femaleGender.png" alt="femaleGender">
    <img id="unknownGender" class="gender" src="Views/Images/unknownGender.png" alt="unknownGender">
</form>
<form id="order" name="order"  method="post">
    <input id="searchInputBox" type="text" name="search">
    <div class="searchSuggestionContainer">
        <ul id="unordered"></ul>
    </div>
    <input id="submit" type="submit" name="submit">
</form>
</body>
</html>