<?php
include_once 'Core/Controller.php';
include_once 'Models/User.php';
include_once 'Models/Address.php';
include_once "Models/Cart.php";
include_once "Models/CartItem.php";
include_once "Models/Test.php";
include_once "Models/Snake.php";
include_once "Models/CustomerSnakeName.php";
include_once "Models/Sex.php";
include_once "Models/KnownPossibleMorph.php";
include_once "Models/TestedMorph.php";
include_once "Models/Morph.php";
include_once 'Models/Order.php';
class BillingController extends Controller
{
    function billing(): void
    {
        $user = new User($_SESSION['user_id']);
        $address = new Address(pUserId: $_SESSION['user_id']);
        if ($address->getAddressId() < 0 || $address->getUserId() < 0) {
            $this->render(['user' => $user]);
        } else {
            $this->render(['user' => $user, 'address' => $address]);
        }
    }
    function review(): void
    {
        $user = new User($_SESSION['user_id']);
        if (isset($_POST['submit'])) {
            unset($_POST['submit']);
            $cartItems = CartItem::geCartItemByCartIdAndUserId($_SESSION['user_id']);
            $donations = []; //Donations not working yet
            $tests = [];
            $testsCount = 0;
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
                        $testsCount += sizeof($testedMorphs);
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
            }
            $this->render(['user' => $user, 'postData' => $_POST, 'tests' => $tests, 'totalTests' => $testsCount]);
        }
    }
    function orderConfirmed(): void
    {
        $this->render();
    }
}
