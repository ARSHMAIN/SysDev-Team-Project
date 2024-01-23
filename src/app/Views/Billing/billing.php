<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Billing</title>
    <link rel="stylesheet" type="text/css" href="../../../../public/css/billing.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/shared.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/navbar.css">
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
    <section class="" id="center">
        <div class="page">
            <div class="loginRegisterWrapper textAlignStart left column">

                <header class="loginRegisterHeader textAlignCenter">
                    <label><a href="#"><i class="bi bi-arrow-left"></i></a> Shipping And Billing Information</label>
                </header>

                <form action="?controller=billing&action=review" method="post">
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="firstName">First Name</label> </br>
                        </div>
                        <input type="text" name="firstName" disabled>
                        </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="lastName">Last Name</label> </br>
                        </div>
                        <input type="text" name="lastName" disabled>
                        </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="email">Email</label> </br>
                        </div>
                        <input type="email" name="email" disabled> </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="phoneNumber">Phone Number</label> </br>
                        </div>
                        <input type="text" name="phoneNumber">
                        </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="address">Address</label> </br>
                        </div>

                        <input type="text" name="address"> </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="city">City</label> </br>
                        </div>

                        <input type="text" name="city"> </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="province">Province</label> </br>
                        </div>
                        <input type="text" name="province"> </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="postalCode">Postal Code</label> </br>
                        </div>
                        <input type="text" name="postalCode"> </br>
                    </div>
                    <div class="loginRegisterInputLabelText widthMinContent marginAuto">
                        <div>
                            <label for="country">Country</label> </br>
                        </div>

                        <input type="text" name="country"> </br>
                    </div>

            </div>
            <div class="right column">
                <div class="loginRegisterInputLabelText sidenav">
                <label><strong> Check out </strong></label></br></br>
                    <label>Subtotal: $</label></br></br>
                    <label>Tax: $</label></br></br>
                    <footer>
                        <hr>
                        <label>Total: $</label></br></br>
                        <div class="signButtons widthMinContent marginAuto">
                            <div class="loginSignUpButton">
                                <input style="color: black" type="submit" name="submit"
                                    class="cursorPointer width100Percent" value="Continue">
                            </div>
                        </div>
                    </footer>
                    <div class="gap"></div>
                </div>
            </div>

            </form>
            <footer class="loginRegisterHeader textAlignCenter">
                <label></label>
            </footer>
        </div>
    </section>
</body>

</html>