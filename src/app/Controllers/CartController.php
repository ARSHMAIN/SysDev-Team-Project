<?php

namespace MyApp\Controllers;

use Core\Controller;
use MyApp\Models\Cart;
use MyApp\Models\CartItem;

class CartController extends Controller
{
    function cart(): void
    {
        $mainSnakeInfo = Cart::getMainSnakeInfo($_SESSION['user_id']);
        $knownAndPossibleMorphs = Cart::getKnownAndPossibleMorphs($_SESSION['user_id']);
        $testedMorphs = Cart::getTestedMorphs($_SESSION['user_id']);
        $this->render([
            'mainSnakeInfo' => $mainSnakeInfo,
            'knownAndPossibleMorphs' => $knownAndPossibleMorphs,
            'testedMorphs' => $testedMorphs
        ]);
    }

    function addTestToCart(): void
    {
        $checkCart = Cart::getCartByUserId($_SESSION['user_id']);
        if (!isset($checkCart)) {
            Cart::createCart($_SESSION['user_id']);
        }
        $cartItem = CartItem::createCartItem($_SESSION['user_id'], null, $_GET['id']);
        if ($cartItem['isSuccessful'] === true) {
            header('Location: index.php?controller=order&action=test&itemAdded=true');
        } else {
            header('Location: index.php?controller=shared&action=error404');
        }
    }
}