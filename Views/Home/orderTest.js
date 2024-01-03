document.addEventListener("DOMContentLoaded", setUpEventHandlers);

function setUpEventHandlers() {
    setUpMorphEventHandlers();
    setUpSubmitEventHandler();
}

function setUpMorphEventHandlers() {
    const addBtnKnownMorph = document.getElementById('addBtnKnownMorph');
    const addBtnPossibleMorph = document.getElementById('addBtnPossibleMorph');
    const addBtnTestMorph = document.getElementById('addBtnTestMorph');

    const removeBtnKnownMorph = document.getElementById('removeBtnKnownMorph');
    const removeBtnPossibleMorph = document.getElementById('removeBtnPossibleMorph');
    const removeBtnTestMorph = document.getElementById('removeBtnTestMorph');

    addBtnKnownMorph.addEventListener('click', () => addInput('knownMorph'));
    addBtnPossibleMorph.addEventListener('click', () => addInput('possibleMorph'));
    addBtnTestMorph.addEventListener('click', () => addInput('testMorph'));
    removeBtnKnownMorph.addEventListener('click', () => removeInput('knownMorph'));
    removeBtnPossibleMorph.addEventListener('click', () => removeInput('possibleMorph'));
    removeBtnTestMorph.addEventListener('click', () => removeInput('testMorph'));
}

function setUpSubmitEventHandler() {
    let createTestForm = document.getElementsByClassName("order")[0];

    createTestForm.addEventListener("submit", function(submitEvent) {
        const emptyValidationResults = performEmptyValidation();
        /*
            Check whether known morphs, possible morphs or tested morphs contain duplicates
            because there can't be two of the same morphs in known morphs
        */
        const duplicateValidationResults = performDuplicateChecks();

        /*
            Check whether there are duplicates between known and possible morphs
            because a plausible snake morph cannot also be a known morph
        */

        const duplicatesBetweenKnownPossibleMorphsResults = performDuplicateChecksBetweenKnownPossibleMorphs();
        if(
            emptyValidationResults.CustomerSnakeIdEmpty
            || emptyValidationResults.TestMorphTextFieldsEmpty
            || duplicateValidationResults.KnownMorphsContainDuplicates
            || duplicateValidationResults.PossibleMorphsContainDuplicates
            || duplicateValidationResults.TestMorphsContainDuplicates
            || duplicatesBetweenKnownPossibleMorphsResults.DuplicatesExistBetweenKnownPossibleMorphs
        ) {
            submitEvent.preventDefault();
        }

    });
}


function performEmptyValidation() {
    /*
        Check whether the morph text fields are empty
        If test morphs are left empty, tell the user they must add something in the tested morphs
        because they are required
        Also delete the empty morph text fields that are not needed before the form submission
    */
    const customerSnakeIdTextField = document.getElementsByClassName("customerSnakeId")[0];
    const customerSnakeIdLabel = document.getElementsByClassName("customerSnakeIdLabel")[0];
    const customerSnakeIdErrorLabel = "customerSnakeIdErrorLabel";
    const customerSnakeIdEmpty = checkTextFieldEmpty(customerSnakeIdTextField);
    addOrRemoveMorphErrorLabel(
        customerSnakeIdTextField ?? customerSnakeIdLabel,
        customerSnakeIdEmpty,
        customerSnakeIdErrorLabel,
        "Customer snake ID is required"
    );

    addOrRemoveMorphErrorLabel(
        customerSnakeIdTextField ?? customerSnakeIdLabel,
        customerSnakeIdEmpty,
        customerSnakeIdErrorLabel,
        "Customer snake ID is required");

    let knownMorphLabel = document.getElementsByClassName(MorphLabelClasses.KnownMorph)[0];
    deleteEmptyMorphTextFields(MorphInputClass.KnownMorph, knownMorphLabel);

    let possibleMorphLabel = document.getElementsByClassName(MorphLabelClasses.PossibleMorph)[0];
    deleteEmptyMorphTextFields(MorphInputClass.PossibleMorph, possibleMorphLabel);

    let testMorphLabel = document.getElementsByClassName(MorphLabelClasses.TestMorph)[0];
    let testMorphLabelPlacement = testMorphLabel
        .nextElementSibling
        .nextElementSibling
        .nextElementSibling
        .nextElementSibling;

    let testMorphTextFieldsEmpty = deleteEmptyMorphTextFields(MorphInputClass.TestMorph, testMorphLabelPlacement, true);
    /*
        Tell the user that they must enter at least one tested morphs into the text fields
    */
    const testMorphErrorLabel = "testMorphErrorLabel";
    const lastTestMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.TestMorph)
    );
    addOrRemoveMorphErrorLabel(lastTestMorphTextField ?? testMorphLabelPlacement, testMorphTextFieldsEmpty, testMorphErrorLabel, "At least one tested morph is required");

    const emptyValidationResults = {
        CustomerSnakeIdEmpty: customerSnakeIdEmpty,
        TestMorphTextFieldsEmpty: testMorphTextFieldsEmpty
    };
    return emptyValidationResults;
}



function performDuplicateChecks() {
    let knownMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.KnownMorph);
    const dupKnownMorphErrorLabel = "dupKnownMorphErrorLabel";
    let lastKnownMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.KnownMorph)
    );

    addOrRemoveMorphErrorLabel(
        lastKnownMorphTextField,
        knownMorphsContainDuplicates,
        dupKnownMorphErrorLabel,
        "Known morphs cannot contain duplicates");


    const possibleMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.PossibleMorph);
    const dupPossibleMorphErrorLabel = "dupPossibleMorphErrorLabel";
    let lastPossibleMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.PossibleMorph)
    );

    addOrRemoveMorphErrorLabel(
        lastPossibleMorphTextField,
        possibleMorphsContainDuplicates,
        dupPossibleMorphErrorLabel,
        "Possible morphs cannot contain duplicates");


    let testMorphsContainDuplicates = false;
    testMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.TestMorph);
    const dupTestMorphErrorLabel = "dupTestMorphErrorLabel";
    const lastTestMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.TestMorph)
    );
    addOrRemoveMorphErrorLabel(
        lastTestMorphTextField,
        testMorphsContainDuplicates,
        dupTestMorphErrorLabel,
        "Tested morphs cannot contain duplicates"
    );

    const duplicateValidationResults = {
        KnownMorphsContainDuplicates: knownMorphsContainDuplicates,
        PossibleMorphsContainDuplicates: possibleMorphsContainDuplicates,
        TestMorphsContainDuplicates: testMorphsContainDuplicates
    };
    return duplicateValidationResults;
}

function performDuplicateChecksBetweenKnownPossibleMorphs() {
    let knownMorphInputs = document.getElementsByClassName(MorphInputClass.KnownMorph);
    let possibleMorphInputs = document.getElementsByClassName(MorphInputClass.PossibleMorph);
    let duplicatesExistBetweenKnownPossibleMorphs = areThereDuplicatesBetweenHtmlCollectionsValues(knownMorphInputs, possibleMorphInputs);
    let lastKnownMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.KnownMorph)
    );
    let lastPossibleMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.PossibleMorph)
    );

    const dupBetweenKnownMorphErrorLabel = "dupBetweenKnownMorphErrorLabel";
    const dupBetweenPossibleMorphErrorLabel = "dupBetweenPossibleMorphErrorLabel";
    addOrRemoveMorphErrorLabel(
        lastKnownMorphTextField,
        duplicatesExistBetweenKnownPossibleMorphs,
        dupBetweenKnownMorphErrorLabel,
        "Duplicate morphs between known and possible morphs");
    addOrRemoveMorphErrorLabel(
        lastPossibleMorphTextField,
        duplicatesExistBetweenKnownPossibleMorphs,
        dupBetweenPossibleMorphErrorLabel,
        "Duplicate morphs between known and possible morphs"
    );

    const duplicatesBetweenKnownPossibleMorphsResults = {
        DuplicatesExistBetweenKnownPossibleMorphs: duplicatesExistBetweenKnownPossibleMorphs
    };
    return duplicatesBetweenKnownPossibleMorphsResults;
}

