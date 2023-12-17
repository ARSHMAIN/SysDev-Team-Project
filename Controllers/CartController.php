<?php
include "Views/Shared/session.php";
include_once "Models/Cart.php";
include_once "Models/CartItem.php";
include_once "Models/Test.php";
include_once "Models/Snake.php";
include_once "Models/CustomerSnakeName.php";
include_once "Models/Sex.php";
include_once "Models/KnownPossibleMorph.php";
include_once "Models/TestedMorph.php";
include_once "Models/Morph.php";
class CartController
{
    function route(): void
    {
        global $action;
        if ($action == "cart") {
            $cartItems = CartItem::geCartItemByCartIdAndUserId($_SESSION['user_id']);
            $donations = [];
            $tests = [];
            if ($cartItems) {
                foreach ($cartItems as $item) {
                    if ($item->getDonationId() !== null) {
                        $donation = null;
                        $donations[] = $donation;
                    } else if ($item->getTestId() !== null) {
                        $test = new Test($item->getTestId());
                        $snake = new Snake($test->getSnakeId());
                        $customerSnakeId = new CustomerSnakeName($snake->getSnakeId());
                        $sex = new Sex($snake->getSexId());
                        $knownMorphs = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snake->getSnakeId(), true);
                        $possibleMorphs = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snake->getSnakeId(), false);
                        $testedMorphs = TestedMorph::getAllTestedMorphById($test->getTestId());
                        $tests[] = [
                            'testId' => $test->getTestId(),
                            'customerSnakeId' => $customerSnakeId->getCustomerSnakeId(),
                            'sex' => $sex->getSexName(),
                            'origin' => $snake->getSnakeOrigin(),
                            'knownMorphs' => Morph::getMorphNames($knownMorphs),
                            'possibleMorphs' => Morph::getMorphNames($possibleMorphs),
                            'testedMorphs' => Morph::getMorphNames($testedMorphs)
                        ];
                    }
                }
                $this->render($action, ['tests' => $tests, 'donations' => $donations]);
            } else {
                $this->render($action);
            }
        } else if ($action == "checkCart") {
            $this->render($action);
        } else if ($action == "addTestToCart") {
            $this->render($action);
        }
    }

    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Cart/$action.php";
    }
}