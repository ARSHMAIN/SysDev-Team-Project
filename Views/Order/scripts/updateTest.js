document.addEventListener("DOMContentLoaded", setUpEventHandlers);


function setUpEventHandlers() {
    setUpMorphEventHandlers();
    setUpSubmitEventHandler();
}


function setUpMorphEventHandlers() {
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
    let updateTestForm = document.getElementsByClassName("order")[0];

    updateTestForm.addEventListener("submit", function(submitEvent) {
        const emptyValidationResults = performEmptyValidationUpdateTest();
        const duplicateChecksResults = performDuplicateChecks();
        const duplicateChecksBetweenKnownPossibleMorphsResults = performDuplicateChecksBetweenKnownPossibleMorphs();

        if(emptyValidationResults.TestMorphTextFieldsEmpty
            || duplicateChecksResults.KnownMorphsContainDuplicates
            || duplicateChecksResults.PossibleMorphsContainDuplicates
            || duplicateChecksResults.TestMorphsContainDuplicates
            || duplicateChecksBetweenKnownPossibleMorphsResults
        ) {
            submitEvent.preventDefault();
        }
    });
}

function performEmptyValidationUpdateTest() {
    /*
        Check whether the morph text fields are empty
        If test morphs are left empty, tell the user they must add something in the tested morphs
        because they are required
        Also delete the empty morph text fields that are not needed before the form submission
    */
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
        TestMorphTextFieldsEmpty: testMorphTextFieldsEmpty
    };
    return emptyValidationResults;
}