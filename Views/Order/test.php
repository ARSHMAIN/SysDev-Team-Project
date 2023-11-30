<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/home.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/test.css">
    <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>
    <script src="Views/Shared/Scripts/toggleGender.js" defer></script>
    <script src="Views/Shared/Scripts/searchDropdown.js" defer></script>
    <script src="Views/Home/orderTest.js" defer></script>
</head>
<body>
<?php
include_once 'Views/Shared/navbar.php';
?>
<h1>Order Test</h1>
<h3>Full Name</h3>
<div class="form-container">
    <form id="order" name="order" method="post">
        <label for="customerSnakeId">Snake ID</label><br>
        <input id="customerSnakeId" type="text" name="customerSnakeId"><br>
        <img id="maleGender" class="gender" src="Views/Images/maleGender.png" alt="maleGender">
        <img id="femaleGender" class="gender" src="Views/Images/femaleGender.png" alt="femaleGender">
        <img id="unknownGender" class="gender" src="Views/Images/unknownGender.png" alt="unknownGender"><br>
        <label for=">knownMorphs">Known morphs</label><br>
        <img id="addBtn" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="removeSign">
        <img id="removeBtn" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
        <input id="knownMorphs" type="text" name="knownMorphs1"><br>
        <input id="knownMorphs" type="text" name="knownMorphs2"><br>
        <label for=">possibleMorphs">Possible morphs</label><br>
        <img id="addBtn" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="removeSign">
        <img id="removeBtn" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
        <input id="possibleMorphs" type="text" name="possibleMorphs1"><br>
        <input id="possibleMorphs" type="text" name="possibleMorphs2"><br>
        <label for=">testMorphs">Test morphs</label><br>
        <img id="addBtn" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="removeSign">
        <img id="removeBtn" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
        <input id="testMorphs" type="text" name="testMorphs1"><br>
        <input id="testMorphs" type="text" name="testMorphs2"><br>
        <label for=">origin">Snake Origin</label><br>
        <input id="snakeOrigin" type="text" name="morph1"><br>
        <input id="submit" type="submit" name="submit">
    </form>
</div>
</body>
</html>