<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Edit Profile</title>
        <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
        <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
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
            <form action="?controller=user&action=submitEditProfile" method="POST">
                <section class="textAlignCenter">
                    <h1>
                        User information:
                    </h1>
                    <div>
                        <div>
                            <label for="firstName">
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
                            <label for="lastName">
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
                            <label for="phoneNumber">
                                Phone Number:
                            </label>
                        </div>

                        <div>
                            <input type="text" name="phoneNumber" value="<?php echo htmlentities($data["user"]->getPhoneNumber() ?? "", ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label for="companyName">
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
                            <label for="streetNumber">
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
                            <label for="streetName">
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
                            <label for="city">
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
                            <label for="stateOrRegion">
                                State/Region:
                            </label>
                        </div>

                        <div>
                            <input type="text" name="stateOrRegion" value="<?php echo htmlentities($data["address"]->getStateOrRegion() ?? "", ENT_QUOTES); ?>">
                        </div>
                    </div>

                    <div>
                        <div>
                            <label for="postalCode">
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
                            <label for="country">
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