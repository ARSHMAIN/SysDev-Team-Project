<?php
//include_once "Views/Shared/session.php";
?>

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
    include_once 'Views/Order/orderSubCategories.php';
    if (isset($_SESSION['error'])) {
        var_dump($_SESSION['error']);
    }
    echo "<br>";
    if (isset($_SESSION['MissingFieldError'])) {
        var_dump($_SESSION['MissingFieldError']);
    }
    ?>
    <h1>Update Order Test</h1>
    <?php
    echo "<h3>" . $data['user']->getFirstName() . ' ' . $data['user']->getLastName() . "</h3>";
    $sex = strtolower($data['tests']['sex']);
    $sexGender = $sex . "Gender";
    ?>

    <div class="form-container">
        <form id="order" name="order" action="/?controller=order&action=updateTest" method="post">
            <label for="customerSnakeId">Snake ID</label><br>
            <input id="customerSnakeId" type="text" name="customerSnakeId" value="ARSH"><br>
            <?php
            if ($sexGender === "maleGender") {
                echo "<img id='maleGender' class='gender selected' src='Views/Images/maleGender.png' alt='maleGender'>";
            } else {
                echo "<img id='maleGender' class='gender' src='Views/Images/maleGender.png' alt='maleGender'>";
            } if ($sexGender === "femaleGender") {
                echo "<img id='femaleGender' class='gender selected' src='Views/Images/femaleGender.png' alt='femaleGender'>";
            } else {
                echo "<img id='femaleGender' class='gender' src='Views/Images/femaleGender.png' alt='femaleGender'>";
            } if ($sexGender === "unknownGender") {
                echo "<img id='unknownGender' class='gender selected' src='Views/Images/unknownGender.png' alt='unknownGender'>";
            } else {
                echo "<img id='unknownGender' class='gender' src='Views/Images/unknownGender.png' alt='unknownGender'>";
            }
            ?>
            <input type="hidden" id="sex" name="sex" value='<?php echo "$sex"?>'><br>
            <label for="knownMorphs" id="knownMorphLabel">Known morphs</label><br>
            <img id="addBtnKnownMorph" class="add-remove" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
            <img id="removeBtnKnownMorph" class="add-remove" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
            <?php
            if (isset($_SESSION['error_message']) && $_SESSION['error_message'] === 'knownMorph') {
                echo '<label class="error">Morph doesn\'t exists</label><br>';
            }
            ?>
            <?php
            foreach ($data['tests']['knownMorphs'] as $key => $knownMorph) {
                echo "<input class='knownMorph' id='knownMorph$key' type='text' name='knownMorph$key' value='$knownMorph'><br>";
            }
            ?>
            <label for="possibleMorphs" id="possibleMorphLabel">Possible morphs</label><br>
            <img id="addBtnPossibleMorph" class="add-remove" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
            <img id="removeBtnPossibleMorph" class="add-remove" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
            <?php
            foreach ($data['tests']['possibleMorphs'] as $key => $possibleMorph) {
                echo "<input class='possibleMorph' id='possibleMorph$key' type='text' name='possibleMorph$key' value='$possibleMorph'><br>";
            }
            ?>
            <label for="testMorphs" id="testMorphLabel">Test morphs</label><br>
            <img id="addBtnTestMorph" class="add-remove" src="Views/Images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
            <img id="removeBtnTestMorph" class="add-remove" src="Views/Images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
            <?php
            foreach ($data['tests']['testedMorphs'] as $key => $testMorph) {
                echo "<input class='testMorph' id='testMorph$key' type='text' name='testMorph$key' value='$testMorph'><br>";
            }
            ?>
            <label for="snakeOrigin">Snake Origin</label><br>
            <input id="snakeOrigin" type="text" name="snakeOrigin" value="<?php echo $data['tests']['origin'] ?>"><br>
            <input id="submit" type="submit" name="submit">
        </form>
    </body>
    </html>
<?php
unset($_SESSION['error']);
unset($_SESSION['duplicate_error']);
unset($_SESSION['MissingFieldError']);
?>