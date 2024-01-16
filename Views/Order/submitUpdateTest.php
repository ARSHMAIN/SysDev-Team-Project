<?php
    $postNamesAccepted = [
        "sex",
        MorphInputClass::KnownMorph->value,
        MorphInputClass::PossibleMorph->value,
        MorphInputClass::TestMorph->value,
        "snakeOrigin",
        "submit"
    ];

    $postNamesRequired = [
      "sex",
      MorphInputClass::TestMorph->value,
      "submit"
    ];

    $postDataAccepted = ValidationHelper::isPostDataAccepted($postNamesAccepted, $_POST);
    $postDataRequired = ValidationHelper::isPostDataRequired($postNamesRequired, $_POST);



    $errorExistsRedirectLocation = "?controller=order&action=updateTest&id=" . $_GET["id"];
    if($postDataAccepted && $postDataRequired) {

        /*
            Check whether the sex exists that was sent through the form
        */

        // Redirect location in case that there was an error when updating the test

        // Validate that sex and snake origin associative pairs are of length 1

        // Validate the snake's sex and origin's data types because
        // they might be arrays, and if they are,
        // it means the user tampered with the form using developer tools
        // and the data is invalid
        ValidationHelper::validateSnakeSexAndOrigin();

        // Perform empty, duplicate validation checks on morphs
        $allMorphsValidationResults = ValidationHelper::validateAllMorphTextFields();
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::UpdateTest->value . $_GET["id"]);

        /*
            Check whether the test actually exists because the ID sent through GET parameters may not be valid
        */
        $testExistsResults = [];
        try {
            $testExistsResults = Test::checkTestExists($_GET["id"]);

            ValidationHelper::shouldAddError(!$testExistsResults["testExists"], "There was an error when updating the test");
            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::UpdateTest->value . $_GET["id"]);
        }
        catch(InvalidArgumentException $argumentException) {
            // An invalid argument exception could be thrown if the GET parameter is of incorrect type
            ValidationHelper::shouldAddError(true, "There was an error when updating the test");
            ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::UpdateTest->value . $_GET["id"]);
        }


        $sexExistsResults = Sex::checkSexExists($_POST["sex"]);
        ValidationHelper::shouldAddError(!$sexExistsResults["sexExists"], "Invalid snake sex");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::UpdateTest->value . $_GET["id"]);



        $customerSnakeName = new CustomerSnakeName($testExistsResults["associatedTest"]->getSnakeId());
        /*
            Update the snake's sex and its origin
        */
        $snakeOrigin                = $_POST["snakeOrigin"];
        $snakeSexUpdateResults       = Snake::updateSnake($_SESSION["user_id"],
            $sexExistsResults["snakeSex"]->getSexId(),
            $snakeOrigin ?? null,
            $customerSnakeName->getSnakeId());
        $snakeSexUpdateIsSuccessful = $snakeSexUpdateResults["isSuccessful"];
        ValidationHelper::shouldAddError(!$snakeSexUpdateIsSuccessful, "There was an error when updating the snake sex");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::UpdateTest->value . $_GET["id"]);
        /*
            Get the IDs of known morphs and tested morphs and delete those that don't exist anymore
        */
        $knownMorphIdsByNameInputted = Morph::getMorphIds($_POST[MorphInputClass::KnownMorph->value]);
        $possibleMorphIdsByNameInputted = Morph::getMorphIds($_POST[MorphInputClass::PossibleMorph->value]);
        $testMorphIdsByNameInputted = Morph::getMorphIds($_POST[MorphInputClass::TestMorph->value]);

        KnownPossibleMorph::deleteAllRemovedKnownPossibleMorphs(
            $customerSnakeName->getSnakeId(),
            ErrorRedirectLocation::UpdateTest->value . $testExistsResults["associatedTest"]->getTestId(),
            $knownMorphIdsByNameInputted,
            $possibleMorphIdsByNameInputted,
        );

        $deleteRemovedTestMorphIsSuccessful = TestedMorph::deleteRemovedTestedMorphs(
            $testExistsResults["associatedTest"]->getTestId(),
            $testMorphIdsByNameInputted
        );
        ValidationHelper::shouldAddError(!$deleteRemovedTestMorphIsSuccessful, "An error occurred when deleting the tested morphs");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::UpdateTest->value . $testExistsResults["associatedTest"]->getTestId());

        /*
         * Insert known, possible, test morphs if they don't exist already
        */
        Morph::insertKnownPossibleMorphsIfNotExists(
            $customerSnakeName->getSnakeId(),
            ErrorRedirectLocation::UpdateTest->value . $_GET["id"],
            $knownMorphIdsByNameInputted,
            $possibleMorphIdsByNameInputted,
        );

        $testedMorphsInsertIsSuccessful = TestedMorph::createIfNotExists(
            $testExistsResults["associatedTest"]->getTestId(),
            $testMorphIdsByNameInputted
        );
        ValidationHelper::shouldAddError(!$testedMorphsInsertIsSuccessful, "An error occurred when inserting the tested morphs");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::UpdateTest->value . $_GET["id"]);

        header("Location: ?controller=cart&action=cart");
    }
    else {
        ValidationHelper::shouldAddError(!$postDataAccepted || !$postDataRequired,
            "Input elements sent through POST request are not as expected
             (there was an input element with an inappropriate name attribute sent through the POST request)");
        ValidationHelper::checkSessionErrorExists(ErrorRedirectLocation::UpdateTest->value . $_GET["id"]);
    }