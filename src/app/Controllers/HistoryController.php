<?php

namespace MyApp\Controllers;

use Core\Controller;
use MyApp\Models\KnownPossibleMorph;
use MyApp\Models\Morph;
use MyApp\Models\Order;
use MyApp\Models\Sex;
use MyApp\Models\Snake;
use MyApp\Models\Test;
use MyApp\Models\CustomerSnakeName;
use MyApp\Models\TestedMorph;

class HistoryController extends Controller
{
    function orderHistory(): void
    {
        if (isset($_POST['submit'])) {
            $sanitizedSearch = htmlentities($_POST['search']);
            $customerSnakeId = CustomerSnakeName::getByUserIdAndLikeCustomerSnakeName($sanitizedSearch, $_SESSION['user_id']);
            if ($customerSnakeId === null) {
                $orders = Order::getOrderByUserId($_SESSION['user_id']);
                $this->render(['orders' => $orders]);
            } else {
                $tests = Test::getBySnakeIdAndOrderExists($customerSnakeId->getSnakeId());
                if ($tests !== null) {
                    $orders = [];
                    foreach ($tests as $test) {
                        $orders[] = new Order($test->getOrderId());
                    }
                    $this->render(['orders' => $orders]);
                } else {
                    $orders = Order::getOrderByUserId($_SESSION['user_id']);
                    $this->render(['orders' => $orders]);
                }
            }

        } else {
            $orders = Order::getOrderByUserId($_SESSION['user_id']);
            $this->render(['orders' => $orders]);
        }
    }

    function snakeHistory(): void
    {
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
        $this->render(['order' => $order, 'snakes' => $snakes]);
    }

    //TODO search
    function search(): void
    {
        $this->render();
    }
}