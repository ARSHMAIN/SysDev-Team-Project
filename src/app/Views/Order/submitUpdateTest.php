<?php

use MyApp\Models\KnownPossibleMorph;
use MyApp\Models\MorphInputClass;
use MyApp\Models\Sex;
use MyApp\Models\Test;
use MyApp\Models\TestedMorph;
use MyApp\Models\User;

$currentUser        = new User($_SESSION["user_id"]);
    $snakeSex           = Sex::getSexByName($_POST["sex"]);
    $snakeOrigin        = $_POST["snakeOrigin"];


    $knownMorphs    = Morph::getSnakeTestPosts(MorphInputClass::KnownMorph->value);
    $newKnownMorphs = Morph::checkMorphsExist($knownMorphs, MorphError::KnownMorphNonexistent->value);
    $possibleMorphs    = Morph::getSnakeTestPosts(MorphInputClass::PossibleMorph->value);
    $newPossibleMorphs = Morph::checkMorphsExist($possibleMorphs, MorphError::PossibleMorphNonexistent->value);

    $testMorphs    = Morph::getSnakeTestPosts(MorphInputClass::TestMorph->value);
    $newTestMorphs = Morph::checkMorphsExist($testMorphs, MorphError::TestMorphNonexistent->value);
    if(isset($_SESSION["error"])) {
        header("Location: ?controller=order&action=updateTest&id=" . $_GET["id"]);
    }
    /*
        Check whether the customer snake ID was changed
        because the customer is not allowed to change it
    */
    $customerSnakeIdToCompare    = $_POST["customerSnakeId"];
    $areSnakeIdsEqual = CustomerSnakeName::areSnakeIdsEqual($_GET["id"],
        $customerSnakeIdToCompare
    );


    if(isset($_SESSION["error"])) {
        header("Location: ?controller=order&action=updateTest&id=" . $_GET["id"]);
    }
    else {
        /*
            Get the new known morphs and tested morphs and check if
            - For known morphs: if the morphs that they update are only added ones, not removed ones
            - For tested morphs: check if all morphs are tested
         */
        $customerSnakeId = CustomerSnakeName::getByUserIdAndCustomerSnakeName($customerSnakeIdToCompare, $_SESSION["user_id"]);
        $knownMorphsToInsert = Morph::getNewMorphs($customerSnakeId->getSnakeId(), $newKnownMorphs, MorphInputClass::KnownMorph->value, true);
        $newPossibleMorphsCheck = Morph::getNewMorphs($customerSnakeId->getSnakeId(), $newPossibleMorphs, MorphInputClass::PossibleMorph->value, false);
        $morphsIdsByNameInputted = Morph::getMorphIds($newKnownMorphs);
        $deleteRemovedKnownMorphsIsSuccessful = KnownPossibleMorph::deleteRemovedKnownMorphs($customerSnakeId->getSnakeId(), $morphsIdsByNameInputted, true);
        var_dump($deleteRemovedKnownMorphsIsSuccessful);
        if(count($knownMorphsToInsert) > 0) {
            /*
                Get rows of the Morph table according to the names of the morphs inputted by the customer
                and delete those that exist in the database
            */

            if($deleteRemovedKnownMorphsIsSuccessful) {
                $knownMorphsInsertIsSuccessful = KnownPossibleMorph::create($customerSnakeId->getSnakeId(), Morph::getMorphIds($knownMorphsToInsert), true);

            }
            else {
                header("Location: ?controller=order&action=updateTest&id=" . $_GET["id"]);
                // TODO: session error
            }
        }

        /*
            Get all the morphs that are tested and are apart of this list of $newTestMorphs (which are morphs' names)
        */
        $checkedTestMorphs = Morph::getByIsTestedAndName(true, $newTestMorphs);
        $checkedMorphs = [];
        foreach ($checkedTestMorphs as $checkedTestMorph) {
            $checkedMorphs[] = $checkedTestMorph->getMorphId();
        }

        if (sizeof($checkedMorphs) !== sizeof($newTestMorphs)) {
            $_SESSION['error'][] = 'Morphs not for testing';
            header('Location: /?controller=order&action=updateTest&id=' . $_GET["id"]);
        }
        else {
            $test = new Test($_GET["id"]);
            $testMorphIdsByNameInputted = Morph::getMorphIds($newTestMorphs);
            $deleteRemovedTestMorphsIsSuccessful = TestedMorph::deleteRemovedTestedMorphs($test->getTestId(), $testMorphIdsByNameInputted);
            if($deleteRemovedTestMorphsIsSuccessful) {
                $testMorphs = TestedMorph::createTestedMorphsIfNotExists($test->getTestId(), $checkedMorphs);
            }
            else {
                header("Location: ?controller=order&action=updateTest&id=" . $_GET["id"]);
                // TODO: session error
            }
            header("Location: ?controller=cart&action=cart");
        }
    }
