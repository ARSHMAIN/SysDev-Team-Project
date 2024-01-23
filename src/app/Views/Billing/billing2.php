<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Billing</title>
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
            <label><a href="#"><i class="bi bi-arrow-left"></i></a> Shipping And Billing Information</label>
        </header>
        <form action="?controller=billing&action=review" method="post">
            <section class="textAlignStart">
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="firstName">First Name</label> <br>
                    </div>
                    <?php
                    ?>
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
                    <input type="text" name="phoneNumber" value='<?php echo $data['user']->getPhoneNumber() !== null ? $data['user']->getPhoneNumber() : '' ?>'> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="address">Address</label> <br>
                    </div>
                    <?php
                    $address = null;
                    if (isset($data['address']) && $data['address']->getStreetName() !== null) {
                        $addressNames = preg_split('/\s+/', ($data['address']->getStreetName()));
                        foreach ($addressNames as $key => $addressName) {
                            $addressNames[$key] = ucfirst($addressName);
                        }
                        $strAddressName = join(' ', $addressNames);
                        $address = $data['address']->getStreetNumber() . ' billing2.php' . $strAddressName;
                    } else {
                        $address = '';
                    }
                    ?>
                    <input type="text" name="address" value='<?php echo $address ?>'> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="city">City</label> <br>
                    </div>
                    <?php
                    $city = null;
                    if (isset($data['address']) && $data['address']->getCity() !== null) {
                        $cityNames = preg_split('/\s+/', ($data['address']->getCity()));
                        foreach ($cityNames as $key => $cityName) {
                            $cityNames[$key] = ucfirst($cityName);
                        }
                        $city = join(' ', $cityNames);
                    } else {
                        $city = '';
                    }
                    ?>
                    <input type="text" name="city" value='<?php echo $city ?>'> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="province">Province</label> <br>
                    </div>
                    <?php
                    $province = null;
                    if (isset($data['address']) && $data['address']->getStateOrRegion() !== null) {
                        $province = strtoupper($data['address']->getStateOrRegion());
                    } else {
                        $province = '';
                    }
                    ?>
                    <input type="text" name="province" value='<?php echo $province ?>'> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="postalCode">Postal Code</label> <br>
                    </div>
                    <?php
                    $postalCode = null;
                    if (isset($data['address']) && $data['address']->getPostalCode() !== null) {
                        $province = strtoupper($data['address']->getPostalCode());
                    } else {
                        $postalCode = '';
                    }
                    ?>
                    <input type="text" name="postalCode" value='<?php echo $postalCode ?>'> <br>
                </div>
                <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                    <div>
                        <label for="country">Country</label> <br>
                    </div>
                    <?php
                    $country = null;
                    if (isset($data['address']) && $data['address']->getCountry() !== null) {
                        $countryNames = preg_split('/\s+/', ($data['address']->getCountry()));
                        foreach ($countryNames as $key => $countryName) {
                            $countryNames[$key] = ucfirst($countryName);
                        }
                        $country = join(' ', $countryNames);
                    } else {
                        $country = '';
                    }
                    ?>
                    <input type="text" name="country" value='<?php echo $country ?>'> <br>
                </div>

            </section>
            <section class="width">
                <div class="loginRegisterInputLabelText sidenav">
                    <label>Check out: </label><br><br>
                    <label>Subtotal: $</label><br><br>
                    <label>Tax: $</label><br><br>
                    <footer>
                        <hr>
                        <label>Total: $</label><br><br>
                        <div class="signButtons widthMinContent marginAuto">
                            <div class="loginSignUpButton">
                                <input style="color: black" type="submit" name="submit" class="cursorPointer width100Percent"
                                       value="Continue">
                            </div>
                        </div>
                    </footer>
                </div>
            </section>

        </form>
        <footer class="loginRegisterHeader textAlignCenter">
            <label></label>
        </footer>
    </div>
</section>
</body>
</html>