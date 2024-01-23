<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Information</title>
    <link rel="stylesheet" type="text/css" href="../../../../public/css/shared.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/home.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/loginRegister.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/side_nav.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
          integrity="sha384-4LISF5TTJX/fLmGSxO53rV4miRxdg84mZsxmO8Rx5jGtp/LbrixFETvWa5a6sESd" crossorigin="anonymous">
    <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>
    <script src="Views/Shared/Scripts/toggleGender.js" defer></script>
    <script src="Views/Shared/Scripts/searchDropdown.js" defer></script>
    <script src="Views/Home/orderTest.js" defer></script>
</head>
<body>
<?php
include_once 'src/app/Views/Shared/navbar.php';
?>
<section class="loginRegisterWrapper marginAuto" id="center">
    <div>
        <header class="loginRegisterHeader textAlignCenter">
            <label><a href="#"><i class="bi bi-arrow-left"></i></a> Review Mailing Information</label>
        </header>


        <section class="textAlignStart">
            <form action="?controller=billing&action=billing" method="post">
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="firstName">First Name</label> <br>
                    </div>
                    <input type="text" name="firstName" value='<?php echo $data['user']->getFirstName() ?>' disabled>
                    <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="lastName">Last Name</label> <br>
                    </div>
                    <input type="text" name="lastName" value='<?php echo $data['user']->getLastName() ?>' disabled> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="email">Email</label> <br>
                    </div>
                    <input type="email" name="email" value='<?php echo $data['user']->getEmail() ?>' disabled> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="phoneNumber">Phone Number</label> <br>
                    </div>
                    <input type="text" name="phoneNumber" value='<?php echo $data['user']->getPhoneNumber() ?>'
                           disabled> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="address">Address</label> <br>
                    </div>
                    <input type="text" name="address" value='<?php echo $_POST['address'] ?>' disabled> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="city">City</label> <br>
                    </div>
                    <input type="text" name="city" value='<?php echo $_POST['city'] ?>' disabled> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="province">Province</label> <br>
                    </div>
                    <input type="text" name="province" value='<?php echo $_POST['province'] ?>' disabled> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="postalCode">Postal Code</label> <br>
                    </div>
                    <input type="text" name="postalCode" value='<?php echo $_POST['postalCode'] ?>' disabled> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="country">Country</label> <br>
                    </div>
                    <input type="text" name="country" value='<?php echo $_POST['country'] ?>' disabled> <br>
                </div>
                <input type="submit" name="submit" value="Edit">
            </form>


        </section>
    </div>
</section>
<section class="loginRegisterWrapper marginAuto" id="center">
    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
        <header class="loginRegisterHeader textAlignCenter">
            <label><a href="#"><i class="bi bi-arrow-left"></i></a>Review Cart</label>
        </header>
        <?php
        if (isset($data['tests'])) {
        ?>
        <section class="textAlignStart">
            <header class="loginRegisterHeader textAlignCenter">
                <label>Tests</label><br>
            </header>
            <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                <?php
                foreach ($data['tests'] as $test) {
                    echo "<td>" . $test['customerSnakeId'] . "</td>";
                    echo "<td>" . $test['sex'] . "</td>";
                    echo "<td>" . $test['origin'] . "</td>";
                    $stringKnownMorph = implode(', ', $test['knownMorphs']);
                    $stringPossibleMorph = implode(', ', $test['possibleMorphs']);
                    $stringTestedMorph = implode(', ', $test['testedMorphs']);
                    echo "<td>" . $stringKnownMorph . "</td>";
                    echo "<td>" . $stringPossibleMorph . "</td>";
                    echo "<td>" . $stringTestedMorph . "</td>";
                }
                ?>
            </div>
            <a href="?controller=cart&action=cart"><button>Edit</button></a>
        </section>
        <?php
        }
        ?>
    </div>
</section>
<section class="width">
    <div class="loginRegisterInputLabelText sidenav">
        <?php
        $subtotal = $data['totalTests'] * 50;
        $tax = $subtotal * .15;
        $total = $subtotal + $tax;
        ?>
        <label>Check out: </label><br><br>
        <label>Subtotal: $<?php echo number_format($subtotal, 2) ?></label><br><br>
        <label>Tax: $<?php echo number_format($tax, 2) ?></label><br><br>
        <footer>
            <hr>
            <label>Total: $<?php echo number_format($total, 2) ?></label><br><br>
            <div class="signButtons widthMinContent marginAuto">
                <div class="loginSignUpButton">
                    <a  href="?controller=billing&action=orderConfirmed" class="width100Percent"><button style="color: black" class="cursorPointer">Place Order</button></a>
                </div>
            </div>
        </footer>
    </div>
</section>

<footer class="loginRegisterHeader textAlignCenter">
    <label></label>
</footer>
</section>
</body>
</html>