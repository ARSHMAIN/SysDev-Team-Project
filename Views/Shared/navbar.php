<nav>
    <section class="profileSection">
        <img src="Views/Images/profile.png" alt="account">
    </section>
    <section class="navBar">
        <section class="logoSection">
            <div>
                <h2>LOGO</h2>
            </div>
        </section>
        <section class="navBarButtons displayFlex alignItemsCenter">
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
                    echo "<a href='/?controller=login&action=login'>Sign In</a>";
                }
                if (isset($_SESSION['user_id'])) {
                    echo "<a href='/?controller=order&action=order'>Order</a>";
                }
                ?>
            </div>
        </section>
    </section>
</nav>
