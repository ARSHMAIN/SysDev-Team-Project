<?php
include_once 'Core/Controller.php';
include_once 'Models/User.php';
include_once 'Models/Snake.php';
include_once 'Models/Sex.php';
include_once 'Models/Morph.php';
include_once 'Models/KnownPossibleMorph.php';
include_once 'Models/CustomerSnakeName.php';
include_once 'Models/Test.php';
include_once 'Models/TestedMorph.php';
class OrderController extends Controller
{
    function order(): void
    {
        $this->render();
    }
    function test(): void
    {
        $user = new User($_SESSION['user_id']);
        $this->render(['user' => $user]);
    }
    function createTest(): void
    {
        $this->render();
    }
    function updateTest(): void
    {
        $user = new User($_SESSION['user_id']);
        if (isset($_GET['id'])) {
            $test = new Test($_GET['id']);
            $snake = new Snake($test->getSnakeId());
            $customerSnakeId = new CustomerSnakeName($snake->getSnakeId());
            $sex = new Sex($snake->getSexId());
            $knownMorphs = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snake->getSnakeId(), true);
            $possibleMorphs = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snake->getSnakeId(), false);
            $testedMorphs = TestedMorph::getAllTestedMorphById($test->getTestId());
            $tests = [
                'testId' => $test->getTestId(),
                'customerSnakeId' => $customerSnakeId->getCustomerSnakeId(),
                'sex' => $sex->getSexName(),
                'origin' => $snake->getSnakeOrigin(),
                'knownMorphs' => Morph::getMorphNames($knownMorphs),
                'possibleMorphs' => Morph::getMorphNames($possibleMorphs),
                'testedMorphs' => Morph::getMorphNames($testedMorphs)
            ];
            $this->render(['user' => $user, 'tests' => $tests]);
        }
    }
    function deleteTest(): void
    {
        $this->render();
    }
    function submitUpdateTest(): void
    {
        $this->render();
    }
}