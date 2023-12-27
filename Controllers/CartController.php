<?php
class CartController extends Controller
{
    function cart(): void
    {
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
            $this->render(['tests' => $tests, 'donations' => $donations]);
        } else {
            $this->render();
        }
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