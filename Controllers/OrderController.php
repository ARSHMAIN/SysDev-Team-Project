<?php
include_once 'Views/Shared/session.php';
include_once 'Models/User.php';
include_once 'Models/Snake.php';
include_once 'Models/Sex.php';
include_once 'Models/Morph.php';
include_once 'Models/KnownPossibleMorph.php';
include_once 'Models/CustomerSnakeName.php';
include_once 'Models/Test.php';
include_once 'Models/TestedMorph.php';
class OrderController
{
    function route(): void
    {
        $user = new User($_SESSION['user_id']);
        global $action;
        if ($action == 'order') {
            $this->render($action);
        } else if ($action == 'test') {
            $this->render($action, ['user' => $user]);
        } else if ($action == 'createTest') {
            $this->render($action);
        } else if ($action == 'updateTest') {
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
                $this->render($action, ['user' => $user, 'tests' => $tests]);
            }
        } else if ($action == 'deleteTest') {
            $this->render($action);
        }
        else if($action == "submitUpdateTest") {
            $this->render($action);
        }
    }

    private function render(string $action, array $data = []): void
    {
        extract($data);
        include_once "Views/Order/$action.php";
    }
}