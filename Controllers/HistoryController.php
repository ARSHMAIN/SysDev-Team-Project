<?php
include_once 'Views/Shared/session.php';
include_once 'Models/Order.php';
include_once 'Models/OrderStatus.php';
include_once 'Models/Test.php';
include_once 'Models/CustomerSnakeName.php';
include_once 'Models/Snake.php';
include_once 'Models/Sex.php';
include_once 'Models/KnownPossibleMorph.php';
include_once 'Models/TestedMorph.php';
include_once 'Models/Morph.php';
class HistoryController
{
    function route(): void
    {
        global $action;
        if ($action == "orderHistory"){
            if (isset($_POST['submit'])) {
                $sanitizedSearch = htmlentities($_POST['search']);
                $customerSnakeId = CustomerSnakeName::getByUserIdAndLikeCustomerSnakeName($sanitizedSearch, $_SESSION['user_id']);
                if ($customerSnakeId === null) {
                    $orders = Order::getOrderByUserId($_SESSION['user_id']);
                    $this->render($action, ['orders' => $orders]);
                }
                else {
                    $tests = Test::getBySnakeIdAndOrderExists($customerSnakeId->getSnakeId());
                    if($tests !== null) {
                        $orders = [];
                        foreach ($tests as $test) {
                            $orders[] = new Order($test->getOrderId());
                        }
                    $this->render($action, ['orders' => $orders]);
                    }
                    else {
                        $orders = Order::getOrderByUserId($_SESSION['user_id']);
                        $this->render($action, ['orders' => $orders]);
                    }
                }

            } else {
                $orders = Order::getOrderByUserId($_SESSION['user_id']);
                $this->render($action, ['orders' => $orders]);
            }
        } else if ($action == "snakeHistory"){
            $order = new Order($_GET['id']);
            $tests = Test::getByOrderId($_GET['id']);
            $snakeIds = [];
            $customerSnakeIds = [];
            $sexes = [];
            $origins = [];
            $knownMorphs = [];
            $possibleMorphs = [];
            $testedMorphs = [];
            foreach ($tests as $test) {
                $snake = new Snake($test->getSnakeId());
                $customerSnakeId = new CustomerSnakeName($snake->getSnakeId());
                $sex = new Sex($snake->getSexId());
                $knownMorph = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snake->getSnakeId(), true);
                $possibleMorph = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snake->getSnakeId(), false);
                $testedMorph = TestedMorph::getAllTestedMorphById($test->getTestId());
                $snakeIds[] = $snake->getSnakeId();
                $customerSnakeIds[] = $customerSnakeId->getCustomerSnakeId();
                $sexes[] = $sex->getSexName();
                $origins[] = $snake->getSnakeOrigin();
                $knownMorphs[] = Morph::getMorphNames($knownMorph);
                $possibleMorphs[] = Morph::getMorphNames($possibleMorph);
                $testedMorphs[] = Morph::getMorphNames($testedMorph);
            }
            $snakes = [
                'snakeIds' => $snakeIds,
                'customerSnakeIds' => $customerSnakeIds,
                'sexes' => $sexes,
                'origins' => $origins,
                'knownMorphs' => $knownMorphs,
                'possibleMorphs' => $possibleMorphs,
                'testedMorphs' => $testedMorphs,
            ];
            $this->render($action, ['order' => $order, 'snakes' => $snakes]);
        } else if ($action == "search") {
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/History/$action.php";
    }
}