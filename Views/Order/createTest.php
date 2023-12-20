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
            /*
                If there was no morph found matching the current iterated morph in the database,
                add an error to the session error array
            */
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
            /*
                Check if the new morphs typed by the customer also include the old ones
                If the array with the old morphs is not empty after doing this loop
                it means that some old morphs were deleted on the client side so return an error
                (??? not sure if this correct)
            */
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
    /*
        If the array of new morphs is not empty, and the array of old morphs is empty,
        it means that the morphs typed by the customer are the old ones + the new ones
    */
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
/*
    Get the morphs that were sent by post
    and check whether if some that were sent are not morphs (no matter what if they were tested or not)
*/
$knownMorphs = getPosts('knownMorph');
$newKnownMorphs = checkMorphs($knownMorphs, 'knownMorphNonexistent');
$possibleMorphs = getPosts('possibleMorph');
$newPossibleMorphs = checkMorphs($possibleMorphs, 'possibleMorphNonexistent');
$testMorphs = getPosts('testMorph');
$newTestMorphs = checkMorphs($testMorphs, 'testMorphNonexistent');

if (isset($_SESSION['error'])) header('Location: index.php?controller=order&action=test');
/*
    If there is no customer snake ID with this particular customer snake ID that exists,
    create a new snake with these known, possible and tested morphs
*/
if (!$customerSnakeId) {
    /*
        Check whether all the old morphs + the new tested morphs (ones that were written client-side)
        are tested
    */
    $checkedTestMorphs = Morph::getByIsTestedAndName(true, $newTestMorphs);
    $checkedMorphs = [];
    foreach ($checkedTestMorphs as $checkedTestMorph) {
        $checkedMorphs[] = $checkedTestMorph->getMorphId();
    }
    /*
        If the list of real morphs (checked by getByIsTestedAndName function)
        is not the same size as the morphs that were sent by the customer, it means that some of the tested
        morphs sent by the customer are not real tested morphs
    */
    if (sizeof($checkedMorphs) !== sizeof($newTestMorphs)) {
        $_SESSION['error'][] = 'Morphs not for testing';
        header('Location: index.php?controller=order&action=test');
    } else {
        /*
            Create a new snake (insert into Snake, CustomerSnakeName, KnownPossibleMorph, Test, TestedMorph tables)
        */
        $snake = Snake::createSnake($_SESSION['user_id'], $sex->getSexId(), $_POST['snakeOrigin']);
        $customerSnakeId = CustomerSnakeName::create($_POST['customerSnakeId'], $_SESSION['user_id'], $snake['newSnakeId']);
        $known = KnownPossibleMorph::create($snake['newSnakeId'], getMorphId($newKnownMorphs), true);
        $possible = KnownPossibleMorph::create($snake['newSnakeId'], getMorphId($newPossibleMorphs), false);
        $test = Test::create($snake['newSnakeId'], $_SESSION['user_id']);
        $testMorphs = TestedMorph::create($test['newTestId'], $checkedMorphs);
        header('Location: index.php?controller=cart&action=addTestToCart&id=' . $test['newTestId']);
    }
} else {
    /*
     * If there is already a snake with this customer snake ID,
     * it means we update the old info with the new information
    */
    $snake = new Snake($customerSnakeId->getSnakeId());
    $oldSex = new Sex($snake->getSexId());
    /*
     * If the sex chosen in the POST variable is not the same as the sex
     * found in the database, add an error that the sex of the snake is wrong to
     * the MissingFieldError session variable
     * Same goes for the snake's origin
    */
    if (ucfirst($_POST['sex']) !== $oldSex->getSexName()) {
        $_SESSION['MissingFieldError']['sex'] = $oldSex->getSexName();
    } if ($origin !== $snake->getSnakeOrigin()) {
        $_SESSION['MissingFieldError']['origin'] = $snake->getSnakeOrigin();
    }
    /*
        Check whether the old known and possible morphs were not deleted
        when they were typed by the customer on the client-side
        If there is an old morph that was deleted, it will throw an error
        because it only accepts old morphs + new morphs as input
    */
    $knownMorphs =  checkOldMorphsInfo($customerSnakeId->getSnakeId(), $newKnownMorphs, 'knownMorph', true);
    $possibleMorphs =  checkOldMorphsInfo($customerSnakeId->getSnakeId(), $newPossibleMorphs, 'possibleMorph', false);
    if (isset($_SESSION['MissingFieldError'])) {
        header('Location: /?controller=order&action=test');
    }
    /*
        Add the new known, possible morphs to the database tables
    */
    if ($knownMorphs !== null) {
        $known = KnownPossibleMorph::create($customerSnakeId->getSnakeId(), getMorphId($knownMorphs), true);
    } if ($possibleMorphs !== null) {
        KnownPossibleMorph::create($customerSnakeId->getSnakeId(), getMorphId($possibleMorphs), false);
    }
    /*
        Check whether all the old morphs + the new tested morphs (ones that were written client-side)
        are tested morphs
    */
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
        header('Location: /?controller=cart&action=addTestToCart&id=' . $test['newTestId']);

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
            header('Location: index.php?controller=order&action=test');
        }
    }
    $possibleMorphs = getPosts('possibleMorph');
    foreach ($knownMorphs as $knownMorph) {
        $morph = Morph::getByName($knownMorph);
        if ($morph) {
            $possibleMorph = KnownPossibleMorph::create(1, $morph->getMorphId(), false);
        } else {
            $_SESSION['error_message'] = 'possibleMorph';
            header('Location: index.php?controller=order&action=test');
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
    header('Location: index.php?controller=order&action=test');
}*/




