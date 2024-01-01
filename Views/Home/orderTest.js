document.addEventListener("DOMContentLoaded", setUpEventHandlers);

function setUpEventHandlers() {
    setUpMorphEventHandlers();
    //setUpSubmitEventHandler();
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
    var createTestForm = document.getElementsByTagName("form")[0];

    createTestForm.addEventListener("submit", function(submitEvent) {
        submitEvent.preventDefault();


        /*
            Check whether the morph text fields are empty
            If test morphs are left empty, tell the user they must add something in the tested morphs
            because they are required
        */
        let knownMorphLabel = document.getElementById(MorphLabelIds.KnownMorph);
        deleteEmptyMorphTextFields(MorphInputClass.KnownMorph, knownMorphLabel);

        let possibleMorphLabel = document.getElementById(MorphLabelIds.PossibleMorph);
        deleteEmptyMorphTextFields(MorphInputClass.PossibleMorph, possibleMorphLabel);

        let testMorphLabel = document.getElementById(MorphLabelIds.TestMorph);
        let testMorphLabelPlacement = testMorphLabel
            .nextElementSibling
            .nextElementSibling
            .nextElementSibling
            .nextElementSibling;
        let testMorphTextFieldsEmpty = deleteEmptyMorphTextFields(MorphInputClass.TestMorph, testMorphLabelPlacement, true);


        const testMorphErrorLabel = "testMorphErrorLabel";
        let lastTestMorphTextField = getLastElementOfHtmlCollection(
            document.getElementsByClassName(MorphInputClass.TestMorph)
        );
        addOrRemoveMorphErrorLabel(lastTestMorphTextField ?? testMorphLabelPlacement, testMorphTextFieldsEmpty, testMorphErrorLabel, "At least one tested morph is required");


        let knownMorphsContainDuplicates = false;

        knownMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.KnownMorph);
        const dupKnownMorphErrorLabel = "dupKnownMorphErrorLabel";
        let lastKnownMorphTextField = getLastElementOfHtmlCollection(
            document.getElementsByClassName(MorphInputClass.KnownMorph)
        );
        addOrRemoveMorphErrorLabel(
            lastKnownMorphTextField,
            knownMorphsContainDuplicates,
            dupKnownMorphErrorLabel,
            "Known morphs cannot contain duplicates");



        let possibleMorphsContainDuplicates = false;

        possibleMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.PossibleMorph);
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
        addOrRemoveMorphErrorLabel(
            lastTestMorphTextField,
            testMorphsContainDuplicates,
            dupTestMorphErrorLabel,
            "Tested morphs cannot contain duplicates");


        if(
            testMorphTextFieldsEmpty
            || knownMorphsContainDuplicates
            || possibleMorphsContainDuplicates
            || testMorphsContainDuplicates
        ) {
            submitEvent.preventDefault();
        }
    });
}



