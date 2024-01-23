<nav>
    <section class="profileSection">
        <?php
            if(isset($_SESSION["user_id"])) {
        ?>
            <div class="userProfileButton floatRight height100Percent displayInlineBlock">

                <div class="height100Percent">
                    <img src="public/images/profile.png" alt="account">
                </div>

                <div class="userProfileDropdown backgroundColorD9D9D9 floatRight positionAbsolute">
                    <div class="userProfileDropdownItem nameDropdownItem backgroundColorBABABA">
                        <label>First Name, Last Name</label>
                    </div>

                    <a class="displayBlock userProfileDropdownItem" href="">Edit Profile</a>
                    <div class="dropdownItemDivider marginAuto"></div>
                    <a class="displayBlock userProfileDropdownItem" href="?controller=login&action=login">Logout</a>
                </div>
            </div>
        <?php
            }
        ?>
    </section>
    <section class="navBar">
        <section class="logoSection">
            <div>
                <h2>LOGO</h2>
            </div>
        </section>
        <section class="navBarButtons displayFlex alignItemsCenter">
<!--            <div>-->
<!--                <a href="index.php?controller=database&action=index">Database</a>-->
<!--            </div>-->
            <div>
                <a href="index.php?controller=home&action=home">Home</a>
            </div>
            <div>
                <a href="index.php?controller=services&action=services">Services</a>
            </div>

            <div>
                <a href="index.php?controller=faq&action=faq">FAQ</a>
            </div>
            <div>
                <a href="index.php?controller=contact&action=contact">Contact Us</a>
            </div>
            <div>
                <?php
                if (!isset($_SESSION['user_id'])) {
                    echo "<a href='index.php?controller=login&action=login'>Sign In</a>";
                }


                if (isset($_SESSION['user_id'])) {
                    echo "<a href='index.php?controller=order&action=order'>Order</a>";
                }
                ?>


            </div>
        </section>
    </section>
</nav>
