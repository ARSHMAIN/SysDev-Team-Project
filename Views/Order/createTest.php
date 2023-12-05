<?php
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
function checkMorphs(array $morphs, string $error): array
{
    $newMorphs = [];
    foreach ($morphs as $key => $morph) {
        $morphObj = Morph::getByName($morph);
        if ($morphObj) {
            $newMorphs[] = $morph;
        }
        else {
            $_SESSION['error'][] = ($key + 1) . $error;
        }
    }
    return $newMorphs;
}
function checkOldMorphsInfo(int $snakeId, array $newMorphs, string $morphType, bool $isKnown): ?array
{
    $oldMorphs = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snakeId, $isKnown);
    if ($oldMorphs) {
        $oldMorphsNames = [];
        foreach ($oldMorphs as $oldMorph) {
            $oldMorphsNames[] = (new Morph($oldMorph->getMorphId()))->getMorphName();
        }
        foreach ($newMorphs as $newMorph) {
            if (!empty($oldMorphsNames && in_array($newMorph, $oldMorphsNames, true))) {
                $oldMorphIndex = array_search($newMorph, $oldMorphsNames);
                $newMorphIndex = array_search($newMorph, $newMorphs);
                unset($oldMorphsNames[$oldMorphIndex]);
                unset($newMorphs[$newMorphIndex]);
                $oldMorphsNames = array_values($oldMorphsNames);
                $newMorphs = array_values($newMorphs);
            }
        }
        if (!empty($oldMorphsNames)) {
            $_SESSION['MissingFieldError'][$morphType] = $oldMorphsNames;
        }
    }
    return empty($newMorphs) ? null : $newMorphs;
}
function getMorphId(array $morphs): array
{
    $morphIds = [];
    foreach ($morphs as $morph) {
        $morphObj = Morph::getByName($morph);
        $morphIds[] = $morphObj->getMorphId();
    }
    return $morphIds;
}
$user = new User($_SESSION['user_id']);
$customerSnakeId = CustomerSnakeName::getByUserIdAndCustomerSnakeName($_POST['customerSnakeId'], $_SESSION['user_id']);
$sex = Sex::getSexByName($_POST['sex']);
$origin = $_POST['snakeOrigin'];
$knownMorphs = getPosts('knownMorph');
$newKnownMorphs = checkMorphs($knownMorphs, 'knownMorphNonexistent');
$possibleMorphs = getPosts('possibleMorph');
$newPossibleMorphs = checkMorphs($possibleMorphs, 'possibleMorphNonexistent');
$testMorphs = getPosts('testMorph');
$newTestMorphs = checkMorphs($testMorphs, 'testMorphNonexistent');

if (isset($_SESSION['error'])) header('Location: /?controller=order&action=test');
if (!$customerSnakeId) {
    $checkedTestMorphs = Morph::getByIsTestedAndName(true, $newTestMorphs);
    $checkedMorphs = [];
    foreach ($checkedTestMorphs as $checkedTestMorph) {
        $checkedMorphs[] = $checkedTestMorph->getMorphId();
    }
    if (sizeof($checkedMorphs) !== sizeof($newTestMorphs)) {
        $_SESSION['error'][] = 'Morphs not for testing';
        header('Location: /?controller=order&action=test');
    } else {
        $snake = Snake::createSnake($_SESSION['user_id'], $sex->getSexId(), $_POST['snakeOrigin']);
        $customerSnakeId = CustomerSnakeName::create($_POST['customerSnakeId'], $_SESSION['user_id'], $snake['newSnakeId']);
        $known = KnownPossibleMorph::create($snake['newSnakeId'], getMorphId($newKnownMorphs), true);
        $possible = KnownPossibleMorph::create($snake['newSnakeId'], getMorphId($newPossibleMorphs), false);
        $test = Test::create($snake['newSnakeId'], $_SESSION['user_id']);
        $testMorphs = TestedMorph::create($test['newTestId'], $checkedMorphs);
        header('Location: /?controller=order&action=order');
    }
} else {
    $snake = new Snake($customerSnakeId->getSnakeId());
    $oldSex = new Sex($snake->getSexId());
    if (ucfirst($_POST['sex']) !== $oldSex->getSexName()) {
        $_SESSION['MissingFieldError']['sex'] = $oldSex->getSexName();
    } if ($origin !== $snake->getSnakeOrigin()) {
        $_SESSION['MissingFieldError']['origin'] = $snake->getSnakeOrigin();
    }
    $knownMorphs =  checkOldMorphsInfo($customerSnakeId->getSnakeId(), $newKnownMorphs, 'knownMorph', true);
    $possibleMorphs =  checkOldMorphsInfo($customerSnakeId->getSnakeId(), $newPossibleMorphs, 'possibleMorph', false);
    if (isset($_SESSION['MissingFieldError'])) {
        header('Location: /?controller=order&action=test');
    }
    if ($knownMorphs !== null) {
        $known = KnownPossibleMorph::create($customerSnakeId->getSnakeId(), getMorphId($knownMorphs), true);
    } if ($possibleMorphs !== null) {
        KnownPossibleMorph::create($customerSnakeId->getSnakeId(), getMorphId($possibleMorphs), false);
    }
    $checkedTestMorphs = Morph::getByIsTestedAndName(true, $newTestMorphs);
    $checkedMorphs = [];
    foreach ($checkedTestMorphs as $checkedTestMorph) {
        $checkedMorphs[] = $checkedTestMorph->getMorphId();
    }
    if (sizeof($checkedMorphs) !== sizeof($newTestMorphs)) {
        $_SESSION['error'][] = 'Morphs not for testing';
        header('Location: /?controller=order&action=test');
    } else {
        $test = Test::create($customerSnakeId->getSnakeId(), $_SESSION['user_id']);
        $testMorphs = TestedMorph::create($test['newTestId'], $checkedMorphs);
        header('Location: /?controller=order&action=order');

    }
}
// Leave this commented code
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




