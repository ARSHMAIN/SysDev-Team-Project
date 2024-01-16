<?php
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
    /*
        Get morph IDs from an array of morph names (gotten from POST request)
    */
    $morphIds = [];
    foreach ($morphs as $morph) {
        $morphObj = Morph::getByName($morph);
        $morphIds[] = $morphObj->getMorphId();
    }
    return $morphIds;
}
$user = new User($_SESSION['user_id']);
$origin = $_POST['snakeOrigin'];

$postNamesAccepted = [
    "customerSnakeId",
    "sex",
    MorphInputClass::KnownMorph->value,
    MorphInputClass::PossibleMorph->value,
    MorphInputClass::TestMorph->value,
    "snakeOrigin",
    "submit"
];

$postNamesRequired = [
    "customerSnakeId",
    "sex",
    MorphInputClass::TestMorph->value,
    "submit"
];

$postDataAccepted = ValidationHelper::isPostDataAccepted($postNamesAccepted, $_POST);
$postDataRequired = ValidationHelper::isPostDataRequired($postNamesRequired, $_POST);

if($postDataAccepted && $postDataRequired) {
    /* Validate the customer snake ID, snake's sex and origin's data types because
       they might be arrays, and if they are,
       it means the user tampered with the form using developer tools
       and the data is invalid
    */
     ValidationHelper::validateRequiredSingleFormValue(
        $_POST["customerSnakeId"],
        "string",
         true,
         "Invalid customer snake ID"
    );
    ValidationHelper::validateSnakeSexAndOrigin();

    // Perform empty, duplicate validation checks on morphs
    $allMorphsValidationResults = ValidationHelper::validateAllMorphTextFields();
    ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::CreateTest->value);


    $customerSnakeName = CustomerSnakeName::getByUserIdAndCustomerSnakeName($_POST['customerSnakeId'], $_SESSION['user_id']);
    // If the customer snake ID does not exist, then create a new snake and other records in other tables
    if (!$customerSnakeName) {
        /*
            Create a new snake (insert into Snake, CustomerSnakeName, KnownPossibleMorph, Test, TestedMorph tables)
        */

        // Check whether the sex the ID sent is actually a real value that is available to be put
        $snakeSexUpdateResults = Sex::checkSexExists($_POST["sex"]);
        $snakeSexUpdateIsSuccessful = $snakeSexUpdateResults["sexExists"];

        ValidationHelper::shouldAddError(!$snakeSexUpdateIsSuccessful, "There was an error creating the snake (invalid sex)");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::CreateTest->value);

        $snakeInsertionResults = Snake::createSnake($_SESSION['user_id'], $snakeSexUpdateResults["snakeSex"]->getSexId(), $_POST['snakeOrigin'] ?? null);
        ValidationHelper::shouldAddError(!$snakeInsertionResults["isSuccessful"], "There was an error creating the snake");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::CreateTest->value);

        $customerSnakeNameInsertionResults = CustomerSnakeName::create($_POST['customerSnakeId'], $_SESSION['user_id'], $snakeInsertionResults['newSnakeId']);
        ValidationHelper::shouldAddError(!$customerSnakeNameInsertionResults["isSuccessful"], "There was an error creating the customer snake name");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::CreateTest->value);

        // Create rows for KnownPossibleMorph and TestedMorph tables
        // Also create a Test record
        $knownMorphsIdsByNameInputted = Morph::getMorphIds($_POST[MorphInputClass::KnownMorph->value]);
        $knownMorphsInsertionIsSuccessful = KnownPossibleMorph::create($snakeInsertionResults['newSnakeId'], $knownMorphsIdsByNameInputted, true);
        ValidationHelper::shouldAddError(!$knownMorphsInsertionIsSuccessful, "Known morphs could not be correctly inserted");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::CreateTest->value);


        $possibleMorphIdsByNameInputted = Morph::getMorphIds($_POST[MorphInputClass::PossibleMorph->value]);
        $possibleMorphsInsertionIsSuccessful = KnownPossibleMorph::create($snakeInsertionResults['newSnakeId'], $possibleMorphIdsByNameInputted, false);
        ValidationHelper::shouldAddError(!$possibleMorphsInsertionIsSuccessful, "Possible morphs could not be correctly inserted");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::CreateTest->value);


        $testInsertionResults = Test::create($snakeInsertionResults['newSnakeId'], $_SESSION['user_id']);
        ValidationHelper::shouldAddError(!$testInsertionResults["isSuccessful"], "Test could not be correctly inserted");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::CreateTest->value);

        $testMorphIdsByNameInputted = Morph::getMorphIds($_POST[MorphInputClass::TestMorph->value]);
        $testMorphsInsertionIsSuccessful = TestedMorph::create($testInsertionResults['newTestId'], $testMorphIdsByNameInputted);
        ValidationHelper::shouldAddError(!$testMorphsInsertionIsSuccessful, "Tested morphs could not be correctly inserted");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::CreateTest->value);

        header('Location: index.php?controller=cart&action=addTestToCart&id=' . $testInsertionResults['newTestId']);
    }
    else {
        /*
         * If there is already a snake with this customer snake ID,
         * it means we update the old info with the new information
        */
        $associatedSnake = new Snake($customerSnakeName->getSnakeId());

        /*
            Delete the ones removed by the customer on the website
            And add the new known, possible morphs to the database tables
        */
        $knownMorphsIdsByNameInputted = Morph::getMorphIds($_POST[MorphInputClass::KnownMorph->value]);
        $possibleMorphsIdsByNameInputted = Morph::getMorphIds($_POST[MorphInputClass::PossibleMorph->value]);

        KnownPossibleMorph::deleteAllRemovedKnownPossibleMorphs(
            $customerSnakeName->getSnakeId(),
            ErrorRedirectLocation::CreateTest->value,
            $knownMorphsIdsByNameInputted,
            $possibleMorphsIdsByNameInputted
        );

        Morph::insertKnownPossibleMorphsIfNotExists(
            $customerSnakeName->getSnakeId(),
            ErrorRedirectLocation::CreateTest->value,
            $knownMorphsIdsByNameInputted,
            $possibleMorphsIdsByNameInputted,
        );

        // Create test and TestedMorph rows (shows which morphs are being tested)
        $testMorphIdsByNameInputted = Morph::getMorphIds($_POST[MorphInputClass::TestMorph->value]);
        $testInsertionResults = Test::create($customerSnakeName->getSnakeId(), $_SESSION['user_id']);
        $testMorphs = TestedMorph::create($testInsertionResults['newTestId'], $testMorphIdsByNameInputted);
        header('Location: /?controller=cart&action=addTestToCart&id=' . $testInsertionResults['newTestId']);
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




