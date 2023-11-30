
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
        <section class="navBarButtons displayFlex">
            <div>
                <a href="index.php?controller=home&action=home"><button>Home</button></a>
            </div>
            <div>
                <a href="index.php?controller=services&action=services"><button>Services</button></a>
            </div>
            <div>
                <a href="index.php?controller=faq&action=faq"><button>FAQ</button></a>
            </div>
            <div>
                <a href="index.php?controller=contact&action=contact"><button>Contact Us</button></a>
            </div>
            <div>
                <?php
                if (!isset($_SESSION['user_id'])) {
                    echo "<a href='/?controller=login&action=login'><button>Sign In</button></a>";
                }
                if (isset($_SESSION['user_id'])) {
                    echo "<a href='/?controller=order&action=order'><button>Order</button></a>";
                }
                ?>
            </div>
        </section>
    </section>
</nav>
