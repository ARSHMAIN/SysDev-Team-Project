<?php
include_once 'Views/Shared/session.php';
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
class BillingController
{
    function route(): void
    {
        global $action;
        $user = new User($_SESSION['user_id']);
        if ($action == "billing"){
            $address = new Address(pUserId: $_SESSION['user_id']);
            if ($address->getAddressId() < 0 || $address->getUserId() < 0) {
                $this->render($action, ['user' => $user]);
            } else {
                $this->render($action, ['user' => $user, 'address' => $address]);
            }
        } else if ($action == "review") {
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
                $this->render($action, ['user' => $user, 'postData' => $_POST, 'tests' => $tests, 'totalTests' => $testsCount]);
            }
            //Else Error page
        } else if ($action == "orderConfirmed") {
            $this->render($action);
        }
        else
        {
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Billing/$action.php";
    }
}
