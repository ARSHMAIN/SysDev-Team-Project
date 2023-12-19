<?php
include_once "Views/Shared/session.php";
?>

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
    <?php
    foreach ($data['order'] as $order) {
        echo "<tr><td>" . $order->getOrderDate() . "</td>";
        echo "<td>$" . $order->getTotal() . "</td>";
        $orderStatus = new OrderStatus($order->getOrderStatusId());
        echo "<td>" . $orderStatus->getOrderStatusName() . "</td></tr>";
    }
    ?>
    </tbody>
</table>

</body>
</html>