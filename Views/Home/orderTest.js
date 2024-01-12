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
        const emptyValidationResults = performEmptyValidationOrderTest();
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
            || duplicatesBetweenKnownPossibleMorphsResults
        ) {
            submitEvent.preventDefault();
        }

    });
}


function performEmptyValidationOrderTest() {
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




