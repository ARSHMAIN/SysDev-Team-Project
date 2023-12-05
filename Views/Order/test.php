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
    <script src="Views/Home/orderTest.js" defer></script>
</head>
<body>
<?php
include_once 'Views/Shared/navbar.php';
if (isset($_SESSION['error'])) {
    var_dump($_SESSION['error']);
}
echo "<br>";
if (isset($_SESSION['MissingFieldError'])) {
    var_dump($_SESSION['MissingFieldError']);
}
?>
<h1>Order Test</h1>
<h3>Full Name</h3>
<div class="form-container">
    <form id="order" name="order" action="/?controller=order&action=createTest" method="post">
        <label for="customerSnakeId">Snake ID</label><br>
        <input id="customerSnakeId" type="text" name="customerSnakeId" value="ARSH"><br>
        <img id="maleGender" class="gender selected" src="Views/Images/maleGender.png" alt="maleGender">
        <img id="femaleGender" class="gender" src="Views/Images/femaleGender.png" alt="femaleGender">
        <img id="unknownGender" class="gender" src="Views/Images/unknownGender.png" alt="unknownGender"><br>
        <input type="hidden" id="sex" name="sex" value="male">
        <label for="knownMorphs" id="knownMorphLabel">Known morphs</label><br>
        <img id="addBtnKnownMorph" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
        <img id="removeBtnKnownMorph" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
        <?php
        if (isset($_SESSION['error_message']) && $_SESSION['error_message'] === 'knownMorph') {
            echo '<label class="error">Morph doesn\'t exists</label><br>';
        }
        ?>
        <input class="knownMorph" id="knownMorph1" type="text" name="knownMorph1" ><br>
        <input class="knownMorph" id="knownMorph2" type="text" name="knownMorph2" ><br>
        <label for="possibleMorphs" id="possibleMorphLabel">Possible morphs</label><br>
        <img id="addBtnPossibleMorph" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
        <img id="removeBtnPossibleMorph" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
        <input class="possibleMorph" id="possibleMorph1" type="text" name="possibleMorph1" ><br>
        <input class="possibleMorph" id="possibleMorph2" type="text" name="possibleMorph2" ><br>
        <label for="testMorphs" id="testMorphLabel">Test morphs</label><br>
        <img id="addBtnTestMorph" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
        <img id="removeBtnTestMorph" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
        <input class="testMorph" id="testMorph1" type="text" name="testMorph1" ><br>
        <input class="testMorph" id="testMorph2" type="text" name="testMorph2" ><br>
        <label for="snakeOrigin">Snake Origin</label><br>
        <input id="snakeOrigin" type="text" name="snakeOrigin" ><br>
        <input id="submit" type="submit" name="submit">
    </form>
</body>
</html>
<?php
unset($_SESSION['error']);
unset($_SESSION['duplicate_error']);
unset($_SESSION['MissingFieldError']);
?>