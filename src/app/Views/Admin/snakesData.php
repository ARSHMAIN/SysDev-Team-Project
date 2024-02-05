<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="../../../../public/css/shared.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/navbar.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/home.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/adminCategories.css">
    <link rel="stylesheet" type="text/css" href="../../../../public/css/adminTable.css">
    <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>
    <script src="Views/Shared/Scripts/toggleGender.js" defer></script>
    <script src="Views/Shared/Scripts/searchDropdown.js" defer></script>
    <script src="Views/Home/orderTest.js" defer></script>
</head>
<body>
<?php
include_once 'src/app/Views/Shared/navbar.php';
?>

<div class="categories">
    <a href="?controller=admin&action=snakesData"><button>Snakes</button></a>
    <a href="?controller=admin&action=ordersData"><button>Orders</button></a>
    <a href="?controller=admin&action=billingInfo"><button>Billing Info</button></a>
    <a href="?controller=admin&action=researchPartners"><button>Research Partners</button></a>
</div>
<section class="table">
    <header>
        <h2>Snake Table</h2>
        <div class="snakeOptions">
            <a href="?controller=admin&action=AddSnake"><button>Add</button></a>
            <a href="#"><button>Save File</button></a>
        </div>
    </header>
</section>
</body>
</html>