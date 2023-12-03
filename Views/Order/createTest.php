<?php
$user = new User($_SESSION['user_id']);
$customerSnakeId = CustomerSnakeName::getByUserIdAndCustomerSnakeName($_POST['customerSnakeId'], $_SESSION['user_id']);
$sex = Sex::getSexByName($_POST['sex']);
$origin = $_POST['snakeOrigin'];
$knownMorphs = getPosts('knownMorph');
$newKnownMorphs = checkMorphs($knownMorphs, 'knownMorphFieldMissing');
$possibleMorphs = getPosts('possibleMorph');
$newPossibleMorphs = checkMorphs($possibleMorphs, 'possibleMorphFieldMissing');
$testMorphs = getPosts('testMorph');
$newTestMorphs = checkMorphs($testMorphs, 'testMorphFieldMissing');

if (isset($_SESSION['error'])) header('Location: /?controller=order&action=test');
if (!$customerSnakeId) {
    $snake = Snake::createSnake($_SESSION['user_id'], $sex->getSexId(), $_POST['snakeOrigin']);
    $customerSnakeId = CustomerSnakeName::create($_POST['customerSnakeId'], $_SESSION['user_id'], $snake['newSnakeId']);
    KnownPossibleMorph::create($snake['newSnakeId'], $newKnownMorphs, true);
    KnownPossibleMorph::create($snake['newSnakeId'], $newPossibleMorphs, false);
    $test = Test::create($snake['newSnakeId'], $_SESSION['user_id']);
    TestedMorph::create($test['newTestId'], $newTestMorphs);
} else {

}
//if (!$customerSnakeId) {
    /*$sex = Sex::getSexByName($_POST['sex']);
    $snake = Snake::createSnake($_SESSION['user_id'], $sex->getSexId(), $_POST['snakeOrigin']);
    $customerSnakeId = CustomerSnakeName::create($_POST['customerSnakeId'], $_SESSION['user_id'], $snake['newSnakeId']);
    var_dump($customerSnakeId);
    $knownMorphs = getPosts('knownMorph');
    foreach ($knownMorphs as $knownMorph) {
        $morph = Morph::getByName($knownMorph);
        if ($morph) {
            $knownMorph = KnownPossibleMorph::create(1, $morph->getMorphId(), true);
        } else {
            $_SESSION['error_message'] = 'knownMorph';
            header('Location: /?controller=order&action=test');
        }
    }
    $possibleMorphs = getPosts('possibleMorph');
    foreach ($knownMorphs as $knownMorph) {
        $morph = Morph::getByName($knownMorph);
        if ($morph) {
            $possibleMorph = KnownPossibleMorph::create(1, $morph->getMorphId(), false);
        } else {
            $_SESSION['error_message'] = 'possibleMorph';
            header('Location: /?controller=order&action=test');
        }
    }*/

    /*foreach ($testMorphs as $key => $testMorph) {
        $morph = Morph::getByName($testMorph);
        if ($morph) {
            continue;
        } else {
            unset($testMorphs[$key]);
            $testMorphs = array_values($testMorphs);
        }
    }*/
   /* $testMorphs = getPosts('testMorph');
    $morphs = checkMorphs($testMorphs, 'testMorphFieldMissing');
    var_dump($morphs);*/
/*} else {

}*/
//CustomerSnakeName::create($_POST['customerSnakeId'], $_SESSION['user_id'], $pSnakeId);
//$sex = Sex::getSexByName($_POST['sex']);
//var_dump($sex);
//$snake = Snake::createSnake($_SESSION['userRole'], $sex->getSexId(), $_POST['snakeOrigin']);
/*$knownMorphs = getPosts('knownMorph');
$possibleMorphs = getPosts('possibleMorph');*/
//$testMorp hs = getPosts('testMorph');

/*if (isset($_SESSION['error'])) {
    header('Location: /?controller=order&action=test');
}*/

function checkMorphs(array $morphs, string $error): array
{
    foreach ($morphs as $key => $morph) {
        $morphObj = Morph::getByName($morph);
        if ($morphObj) continue;
        else {
            $_SESSION['error'][] = ($key + 1) . $error;
            unset($morphs[$key]);
            $morphs = array_values($morphs);
        }
    }
    return $morphs;
}

function getPosts(string $className): array
{
    $i = 1;
    $array = [];
    while (true) {
        $key = $className . $i;
        if (isset($_POST[$key])) {
            $array[] = $_POST[$key];
        } else {
            break;
        }
        $i++;
    }
    return $array;
}
