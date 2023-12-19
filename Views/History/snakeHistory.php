<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="10">
    <title>Order History</title>
    <link rel="stylesheet" type="text/css" href="Views/Styles/shared.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/navbar.css">
    <link rel="stylesheet" type="text/css" href="Views/Styles/home.css">
    <script src="Views/Shared/Scripts/addRemoveInputs.js" defer></script>
    <script src="Views/Shared/Scripts/toggleGender.js" defer></script>
    <script src="Views/Shared/Scripts/searchDropdown.js" defer></script>
    <script src="Views/Home/orderTest.js" defer></script>
</head>
<body>
<?php
include_once 'Views/Shared/navbar.php';
include_once 'Views/Order/orderSubCategories.php';
?>
<table>
    <thead>
    <tr>
        <th>Order Placed On</th>
        <th>Total</th>
        <th>Order Status</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td><?php echo $data['order']->getOrderDate() ?></td>
        <td><?php echo $data['order']->getTotal() ?></td>
        <td><?php echo (new OrderStatus($data['order']->getOrderStatusId()))->getOrderStatusName() ?></td>
    </tr>
    </tbody>
</table>
<table>
    <thead>
    <tr>
        <th>Snake Id</th>
        <th>Sex</th>
        <th>Snake Origin</th>
        <th>Known Morphs</th>
        <th>Possible Morphs</th>
        <th>Tested Morphs</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($data['snakes']['customerSnakeIds'] as $key => $snake) {
        echo "<tr><td>" . $snake . "</td>";
        echo "<td>" . $data['snakes']['sexes'][$key] . "</td>";
        echo "<td>" . $data['snakes']['origins'][$key] . "</td>";
        $stringKnownMorph = implode(', ', $data['snakes']['knownMorphs'][$key]);
        $stringPossibleMorph = implode(', ', $data['snakes']['possibleMorphs'][$key]);
        $stringTestedMorph = implode(', ', $data['snakes']['testedMorphs'][$key]);

        echo "<td>" . $stringKnownMorph . "</td>";
        echo "<td>" . $stringPossibleMorph . "</td>";
        echo "<td>" . $stringTestedMorph . "</td>";
        echo "<td><a href='?controller=history&action=testHistory&id=" . $data['snakes']['snakeIds'][$key] . "'><button>Open Snake</button></a></td>";
    }
    ?>
    </tbody>
</table>

</body>
</html>