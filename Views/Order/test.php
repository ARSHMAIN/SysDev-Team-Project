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
<!--    <script src="Views/Shared/Scripts/toggleGender.js" defer></script>-->
    <script src="Views/Shared/Scripts/morphInputClass.js" defer></script>
    <script src="Views/Shared/Scripts/morphLabelClasses.js" defer></script>
    <script src="Views/Order/scripts/snakeTestValidation.js" defer></script>
    <script src="Views/Shared/Scripts/domManipulationLibrary.js" defer></script>
    <script src="Views/Shared/Scripts/textFieldValidation.js" defer></script>
    <script src="Views/Home/orderTest.js" defer></script>
</head>
<body>
<?php
include_once 'Views/Shared/navbar.php';
include_once 'Views/Order/orderSubCategories.php';
if (isset($_SESSION['error'])) {
    var_dump($_SESSION['error']);
}
echo "<br>";
if (isset($_SESSION['MissingFieldError'])) {
    var_dump($_SESSION['MissingFieldError']);
}
?>
<div class="testDonationHeader marginAuto">
    <h1>Order Test</h1>
    <hr>
</div>

<?php
echo "<h3>" . $data['user']->getFirstName() . ' ' . $data['user']->getLastName() . "</h3>";
?>

<div class="form-container">
    <form class="order" name="order" action="index.php?controller=order&action=createTest" method="post">
        <label class="customerSnakeIdLabel">Snake ID</label><br>
        <input class="customerSnakeId" type="text" name="customerSnakeId"><br>
<!--        <img id="maleGender" class="gender selected" src="Views/Images/maleGender.png" alt="maleGender">-->
<!--        <img id="femaleGender" class="gender" src="Views/Images/femaleGender.png" alt="femaleGender">-->
<!--        <img id="unknownGender" class="gender" src="Views/Images/unknownGender.png" alt="unknownGender">-->
        <br>
        <label>
            <input type="radio" name="sex" value="male" checked>
            <img src="Views/Images/maleGender.png" alt="maleGender">
        </label>

        <label>
            <input type="radio" name="sex" value="female">
            <img src="Views/Images/femaleGender.png" alt="femaleGender">
        </label>
        <label>
            <input type="radio" name="sex" value="unknown">
            <img src="Views/Images/unknownGender.png" alt="unknownGender">
        </label>
<!--        <input type="hidden" id="sex" name="sex" value="male">-->
        <br>
            <label class="knownMorphLabel">Known morphs</label>
        <br>

        <img id="addBtnKnownMorph" class="add-remove" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
        <img id="removeBtnKnownMorph" class="add-remove" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
        <?php
        if (isset($_SESSION['error_message']) && $_SESSION['error_message'] === 'knownMorph') {
            echo '<label class="error">Morph doesn\'t exists</label><br>';
        }
        ?>
        <input class="knownMorph" class="knownMorph" type="text" name="knownMorph[]" ><br>
        <input class="knownMorph" class="knownMorph" type="text" name="knownMorph[]" ><br>
<!--        <div class="errorLabelText">-->
<!--            <label>Known morph field(s) empty</label>-->
<!--        </div>-->
        <label class="possibleMorphLabel">Possible morphs</label><br>
        <img id="addBtnPossibleMorph" class="add-remove" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
        <img id="removeBtnPossibleMorph" class="add-remove" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
        <input class="possibleMorph" class="possibleMorph" type="text" name="possibleMorph[]" ><br>
        <input class="possibleMorph" class="possibleMorph" type="text" name="possibleMorph[]" ><br>
        <label class="testMorphLabel">Test morphs</label><br>
        <img id="addBtnTestMorph" class="add-remove" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
        <img id="removeBtnTestMorph" class="add-remove" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
        <input class="testMorph" class="testMorph" type="text" name="testMorph[]" ><br>
        <input class="testMorph" class="testMorph" type="text" name="testMorph[]" ><br>
        <label>Snake Origin</label><br>
        <input class="snakeOrigin" type="text" name="snakeOrigin" ><br>
        <input id="submit" type="submit" name="submit">
    </form>
</body>
</html>
<?php
unset($_SESSION['error']);
unset($_SESSION['duplicate_error']);
unset($_SESSION['MissingFieldError']);
?>