<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/shared.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/home.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/test.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/cart.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="Views/Shared/Scripts/cart.js"></script>
    <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>
    <script src="Views/Shared/Scripts/toggleGender.js" defer></script>
    <script src="Views/Shared/Scripts/searchDropdown.js" defer></script>
    <script src="Views/Home/orderTest.js" defer></script>
</head>

<body>

    <?php
    include_once 'src/app/Views/Shared/navbar.php';
    ?>
    <div class="page">
        <div class="left column">
            <?php
            include_once 'src/app/Views/Order/orderSubCategories.php';
            ?>
            <h1>Cart</h1>
            <?php
            if (empty($data)) {
                echo "<label>Empty Cart</label>";
            }
            ?>
            <h2>Tests</h2>
            <?php if (!empty($data['mainSnakeInfo'])) { ?>
            <div class="contain-contents">
                <!-- WHERE THE CART CONTENTS ARE DISPLAYED -->
                <?php
                foreach ($data['mainSnakeInfo'] as $mainSnakeInfo) {
                ?>
                    <table id="table">
                        <!-- TODO: APPEND DATA ID TO THIS ITEM SO THEY CAN BE GENERIC AND UNIQUE-->
                        <tr id="item">
                            <td>
                                <div class="photo">
                                    <i class="bi bi-camera-fill"></i>
                                </div>
                            </td>
                            <!--TODO unknown icon doesn't work-->
                            <td>
                                <h3><?php echo $mainSnakeInfo['customerSnakeName']->getCustomerSnakeId() ?> <i class='<?php echo "bi bi-gender-" . strtolower($mainSnakeInfo['sex']->getSexName()) ?>'></i></h3>
                                <strong>Known morphs:</strong>
                                <?php
                                if (array_key_exists($mainSnakeInfo['snake']->getSnakeId(), $data['knownAndPossibleMorphs'])) {
                                    $knownMorphs = join(", ", $data['knownAndPossibleMorphs'][$mainSnakeInfo['snake']->getSnakeId()]['known']);
                                    echo "<p> $knownMorphs, <a href='#'>More...</a></p>";
                                }
                                ?>
                                <strong>Possible morphs:</strong>
                                <?php
                                if (array_key_exists($mainSnakeInfo['snake']->getSnakeId(), $data['knownAndPossibleMorphs'])) {
                                    $possibleMorphs = join(", ", $data['knownAndPossibleMorphs'][$mainSnakeInfo['snake']->getSnakeId()]['possible']);
                                    echo "<p> $possibleMorphs, <a href='#'>More...</a></p>";
                                }
                                ?>
                                <strong>Morphs to test for:</strong>
                                <?php
                                if (array_key_exists($mainSnakeInfo['snake']->getSnakeId(), $data['testedMorphs'])) {
                                    $testedMorphs = join(", ", $data['testedMorphs'][$mainSnakeInfo['snake']->getSnakeId()]);
                                    echo "<p> $testedMorphs, <a href='#'>More...</a></p>";
                                }
                                ?>
                                <strong>Snake origin:</strong>
                                <p><?php echo $mainSnakeInfo['snake']->getSnakeOrigin() ?></p>

                            </td>
                            <td>
                                <div class="crud-icons">
                                    <a href="#" id="copy" name="copy"><i class="bi bi-copy"></i></a>
                                    <a href="#" id="edit" name="edit"><i class="bi bi-pencil"></i></a>
                                    <a href="#" id="delete" name="delete"><i class="bi bi-trash3"></i></a>
                                </div>
                            </td>
                        </tr>
                    </table>
                <?php } ?>
                <table id="table">
                    <!-- TODO: APPEND DATA ID TO THIS ITEM SO THEY CAN BE GENERIC AND UNIQUE-->
                    <tr id="item">
                        <td>
                            <div class="photo">
                                <i class="bi bi-camera-fill"></i>
                            </div>
                        </td>
                        <td>
                            <h3>Snake ID <i class="bi bi-gender-male"></i></h3>
                            <strong>Current morphs:</strong>
                            <p>morph, morph, morph, morph, <a href="#">More...</a></p>
                            <strong>Morphs to test for:</strong>
                            <p>morph, morph, morph, morph, <a href="#">More...</a></p>
                            <strong>Snake origin:</strong>
                            <p>US, Canada, Self-bred</p>

                        </td>
                        <td>
                            <div class="crud-icons">
                                <a href="#" id="copy" name="copy"><i class="bi bi-copy"></i></a>
                                <a href="#" id="edit" name="edit"><i class="bi bi-pencil"></i></a>
                                <a href="#" id="delete" name="delete"><i class="bi bi-trash3"></i></a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <?php } ?>

            <br><br><br>
            
            <h2>Donations</h2>
            <table>
                <thead>
                    <tr>
                        <th>Snake Name</th>
                        <th>Header 2</th>
                        <th>Header 3</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Data 1</td>
                        <td>Data 2</td>
                        <td>Data 3</td>
                    </tr>
                    <tr>
                        <td>Data 4</td>
                        <td>Data 5</td>
                        <td>Data 6</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
        <div class="column right">
            <div class="loginRegisterInputLabelText sidenav">
                <label><strong> Check out </strong></label></br></br>
                <label>Subtotal: $</label></br></br>
                <label>Tax: $</label></br></br>
                <footer>
                    <hr>
                    <label>Total: $</label></br></br>
                    <?php if (!empty($data)) { ?>
                    <div class="signButtons widthMinContent marginAuto">
                        <div class="loginSignUpButton">
                            <form action="?controller=billing&action=billing" method="post">
                            <input style="color: black" type="submit" name="submit"
                                class="cursorPointer width100Percent" value="Continue">
                            </form>
                        </div>
                    </div>
                    <?php } ?>
                </footer>
            </div>
        </div>
    </div>
</body>

</html>