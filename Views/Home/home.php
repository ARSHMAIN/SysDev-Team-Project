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

    <div class="padding">
        <h1>Slogan</h1>
        <center>
            <img src="Views/Images/snake_dummy_image.jpeg" alt="snake image">
        </center>
        <h2>About Us</h2>
        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
        <h2>News</h2>
        <div class="vertical-scroll">
            <!-- there lies the news facebook thing. need API -->
            <!-- APP NAME: Sysdev-team-project-->
            <!-- APP ID: 1053124639146771 -->
            <!-- ACCESS TOKEN: -->
        </div>
    </div>
</body>
</html>