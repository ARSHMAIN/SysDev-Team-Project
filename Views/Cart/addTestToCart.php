<?php
include_once "Views/Cart/checkCart.php";
$cartItem = CartItem::createCartItem($_SESSION['user_id'], null, $_GET['id']);
if ($cartItem['isSuccessful'] === true) {
    header('Location: ?controller=order&action=test&itemAdded=true');
} else {
    header('Location: ?controller=shared&action=error404');
}