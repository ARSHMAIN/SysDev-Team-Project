<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Profile</title>
        <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
        <script src="Views/User/Scripts/editProfile.js" defer></script>
        <script src="Views/Shared/Scripts/textFieldValidation.js" defer></script>
    </head>

    <body>
        <?php
            include_once "Views/Shared/navbar.php"
        ?>
        <main>
            <?php
                if (isset($_SESSION["error"])) {
                    var_dump($_SESSION["error"]);
                }
            ?>
            <form action="?controller=user&action=submitEditProfile" method="POST" class="editProfileForm">
                <section class="textAlignCenter">
                    <h1>
                        User information:
                    </h1>
                    <div>
                        <div>
                            <label class="firstNameLabel" for="firstName">
                                First Name:
                            </label>
                            <span class="requiredAsterisk">
                                *
                            </span>
                        </div>

                        <div>
                            <input type="text" name="firstName" value="<?php echo htmlentities($data["user"]->getFirstName(), ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label class="lastNameLabel" for="lastName">
                                Last Name:
                                <span class="requiredAsterisk">
                                *
                                </span>
                            </label>

                        </div>

                        <div>
                            <input type="text" name="lastName" value="<?php echo htmlentities($data["user"]->getLastName(), ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label>
                                Email:
                                <span class="requiredAsterisk">
                                *
                                </span>
                            </label>

                        </div>

                        <div>
                            <a href="">incomplete feature</a>
                        </div>
                    </div>

                    <div>
                        <div>
                            <label>
                                Password:
                                <span class="requiredAsterisk">
                                *
                                </span>
                            </label>
                        </div>

                        <div>
                            <a href="">incomplete feature</a>
                        </div>
                    </div>


                    <div>
                        <div>
                            <label class="phoneNumberLabel" for="phoneNumber">
                                Phone Number:
                            </label>
                        </div>

                        <div>
                            <input type="text" name="phoneNumber" value="<?php echo htmlentities($data["user"]->getPhoneNumber() ?? "", ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label class="companyNameLabel" for="companyName">
                                Company Name:
                            </label>
                        </div>

                        <div>
                            <input type="text" name="companyName" value="<?php echo htmlentities($data["user"]->getCompanyName() ?? "", ENT_QUOTES);?>">
                        </div>
                    </div>

                    <h2>
                        Address:
                    </h2>
                    <div>
                        <div>
                            <label class="streetNumberLabel" for="streetNumber">
                                Street Number:
                                <span class="requiredAsterisk">
                                *
                                </span>
                            </label>
                        </div>

                        <div>
                            <input type="text" name="streetNumber" value="<?php echo htmlentities($data["address"]->getStreetNumber(), ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label class="streetNameLabel" for="streetName">
                                Street Name:
                                <span class="requiredAsterisk">
                                *
                                </span>
                            </label>
                        </div>

                        <div>
                            <input type="text" name="streetName" value="<?php echo htmlentities($data["address"]->getStreetName(), ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label class="cityLabel" for="city">
                                City:
                                <span class="requiredAsterisk">
                                *
                                </span>
                            </label>
                        </div>

                        <div>
                            <input type="text" name="city" value="<?php echo htmlentities($data["address"]->getCity(), ENT_QUOTES); ?>">
                        </div>
                    </div>


                    <div>
                        <div>
                            <label class="stateOrRegionLabel" for="stateOrRegion">
                                State/Region:
                            </label>
                        </div>

                        <div>
                            <input type="text" name="stateOrRegion" value="<?php echo htmlentities($data["address"]->getStateOrRegion() ?? "", ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label class="postalCodeLabel" for="postalCode">
                                Postal Code:
                                <span class="requiredAsterisk">
                                *
                                </span>
                            </label>
                        </div>

                        <div>
                            <input type="text" name="postalCode" value="<?php echo htmlentities($data["address"]->getPostalCode(), ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label class="countryLabel" for="country">
                                Country:
                                <span class="requiredAsterisk">
                                *
                                </span>
                            </label>
                        </div>

                        <div>
                            <input type="text" name="country" value="<?php echo htmlentities($data["address"]->getCountry(), ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <input type="submit" name="submit" value="Edit Profile">
                    </div>
                </section>
            </form>
        </main>
    </body>
</html>

<?php
unset($_SESSION['error']);
?>