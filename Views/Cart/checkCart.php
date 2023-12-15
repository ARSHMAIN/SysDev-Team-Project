<?php
$checkCart = Cart::getCartByUserId($_SESSION['user_id']);
if (!isset($checkCart)) {
    $checkCart = Cart::createCart($_SESSION['user_id']);
}