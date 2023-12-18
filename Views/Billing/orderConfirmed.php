<?php
$cartItems = CartItem::geCartItemByCartIdAndUserId($_SESSION['user_id']);
$donations = [];
$tests = [];
if ($cartItems) {
    $order = Order::createOrder(false, false, null, $_SESSION['user_id'], 3);
    if ($order['isSuccessful'] === true && isset($order['newOrderId'])) {
        $total = 0;
        foreach ($cartItems as $item) {
            if ($item->getDonationId() !== null) {
                $donation = null;
                $donations[] = $donation;
            } else if ($item->getTestId() !== null) {
                $test = new Test($item->getTestId());
                Test::updateTest($test->getSnakeId(), $order['newOrderId'], $_SESSION['user_id'], $test->getTestId());
                $testedMorphs = TestedMorph::getAllTestedMorphById($test->getTestId());
                $total += sizeof($testedMorphs);
            }
        }
        Order::updateOrder(false, false, $total * 50, $_SESSION['user_id'], 3, $order['newOrderId']);
        Cart::deleteCart($_SESSION['user_id']);
    }
}
header('Location: ?controller=home&action=home');