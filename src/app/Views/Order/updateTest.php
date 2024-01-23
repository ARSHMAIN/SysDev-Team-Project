<?php
//include_once "Views/Shared/session.php";
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" type="text/css" href="../../../../public/css/shared.css">
        <link rel="stylesheet" type="text/css" href="../../../../public/css/navbar.css">
        <link rel="stylesheet" type="text/css" href="../../../../public/css/home.css">
        <link rel="stylesheet" type="text/css" href="../../../../public/css/test.css">
        <link rel="stylesheet" type="text/css" href="../../../../public/css/updateTest.css">
        <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>

<!--        <script src="Views/Shared/Scripts/toggleGender.js" defer></script>-->
<!--        <script src="Views/Home/orderTest.js" defer></script>-->

        <script src="Views/Order/scripts/updateTest.js" defer></script>
    </head>
    <body>
    <?php
    include_once 'src/app/Views/Shared/navbar.php';
    include_once 'src/app/Views/Order/orderSubCategories.php';
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
        <form id="order" name="order" action="index.php?controller=order&action=submitUpdateTest&id=<?php echo $_GET["id"]; ?>" method="post">
            <label for="customerSnakeId">Snake ID</label><br>
            <input id="customerSnakeId" type="text" name="customerSnakeId" value="<?php echo $data["tests"]["customerSnakeId"]; ?>" readonly><br>
<!--            <img id="maleGender" class="gender--><?php //echo (($sexGender === "maleGender")? " selected" : ""); ?><!--" src="public/images/maleGender.png" alt="maleGender">-->
<!--            <img id="femaleGender" class="gender--><?php //echo (($sexGender === "femaleGender")? " selected" : ""); ?><!--" src="public/images/femaleGender.png" alt="femaleGender">-->
<!--            <img id="unknownGender" class="gender--><?php //echo (($sexGender === "unknownGender")? " selected" : ""); ?><!--" src="public/images/unknownGender.png" alt="unknownGender">-->

            <label>
                <input type="radio" name="sex" value="male" <?php echo (($sexGender === "maleGender")? " checked" : " disabled"); ?>>
                <img src="public/images/maleGender.png" alt="maleGender" >
            </label>

            <label>
                <input type="radio" name="sex" value="female" <?php echo (($sexGender === "femaleGender")? " checked" : " disabled"); ?>>
                <img src="public/images/femaleGender.png" alt="femaleGender" >
            </label>
            <label>
                <input type="radio" name="sex" value="unknown"<?php echo (($sexGender === "unknownGender")? " checked" : " disabled"); ?>>
                <img src="public/images/unknownGender.png" alt="unknownGender" >
            </label>
<!--            <input type="hidden" id="sex" name="sex" value='--><?php //echo "$sex"?><!--'>-->
            <br>
            <label for="knownMorphs" id="knownMorphLabel">Known morphs</label><br>
            <img id="addBtnKnownMorph" class="add-remove" src="public/images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
            <img id="removeBtnKnownMorph" class="add-remove" src="public/images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
            <?php
//            if (isset($_SESSION['error_message']) && $_SESSION['error_message'] === 'knownMorph') {
//                echo '<label class="error">Morph doesn\'t exists</label><br>';
//            }
            ?>
            <?php
            foreach ($data['tests']['knownMorphs'] as $key => $knownMorph) {
                echo "<input class='knownMorph' id='knownMorph".  $key + 1 . "' type='text' name='knownMorph" . $key + 1 . "' value='$knownMorph'><br>";
            }
            ?>
            <label for="possibleMorphs" id="possibleMorphLabel">Possible morphs</label><br>
<!--            <img id="addBtnPossibleMorph" class="add-remove" src="public/images/addSign.png" style="width: 2%; height: 2%" alt="addSign">-->
<!--            <img id="removeBtnPossibleMorph" class="add-remove" src="public/images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>-->
            <?php
            foreach ($data['tests']['possibleMorphs'] as $key => $possibleMorph) {
                echo "<input class='possibleMorph' id='possibleMorph" . $key + 1  . "' type='text' name='possibleMorph" . $key + 1 . "' value='$possibleMorph' readonly><br>";
            }
            ?>
            <label for="testMorphs" id="testMorphLabel">Test morphs</label><br>
            <img id="addBtnTestMorph" class="add-remove" src="public/images/addSign.png" style="width: 2%; height: 2%" alt="addSign">
            <img id="removeBtnTestMorph" class="add-remove" src="public/images/removeSign.png" style="width: 2.25%; height: 2.25%" alt="removeSign"><br>
            <?php
            foreach ($data['tests']['testedMorphs'] as $key => $testMorph) {
                echo "<input class='testMorph' id='testMorph" . $key + 1 . "' type='text' name='testMorph" . $key + 1 . "' value='$testMorph'><br>";
            }
            ?>
            <label for="snakeOrigin">Snake Origin</label><br>
            <input id="snakeOrigin" type="text" name="snakeOrigin" value="<?php echo $data['tests']['origin'] ?>" readonly><br>
            <input id="submit" type="submit" name="submit">
        </form>
    </body>
    </html>
<?php
unset($_SESSION['error']);
unset($_SESSION['duplicate_error']);
unset($_SESSION['MissingFieldError']);
?>