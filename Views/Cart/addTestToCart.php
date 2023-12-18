<?php
include_once "Views/Cart/checkCart.php";
$cartItem = CartItem::createCartItem($_SESSION['user_id'], null, $_GET['id']);
if ($cartItem['isSuccessful'] === true) {
    header('Location: index.php?controller=order&action=test&itemAdded=true');
} else {
    header('Location: index.php?controller=shared&action=error404');
}