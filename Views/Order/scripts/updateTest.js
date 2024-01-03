document.addEventListener("DOMContentLoaded", setUpEventHandlers);


function setUpEventHandlers() {
    setUpMorphEventHandlers();
    // setUpSubmitEventHandler();
}


function setUpMorphEventHandlers() {
    const removeBtnPossibleMorph = document.getElementById('removeBtnPossibleMorph');
    const removeBtnTestMorph = document.getElementById('removeBtnTestMorph');

    addBtnKnownMorph.addEventListener('click', () => addInput('knownMorph'));
    addBtnTestMorph.addEventListener('click', () => addInput('testMorph'));
    removeBtnKnownMorph.addEventListener('click', () => removeInput('knownMorph'));
    removeBtnTestMorph.addEventListener('click', () => removeInput('testMorph'));
}

function setUpSubmitEventHandler() {
    let updateTestForm = document.getElementById("order");

    updateTestForm.addEventListener("submit", function(submitEvent) {
        const morphInputIds = [
            "customerSnakeId",
        ];
        let inputsExist = checkInputsExistById(morphInputIds);

        if(inputsExist) {
            /*
            Check whether the morph text fields are empty
            If test morphs are left empty, tell the user they must add something in the tested morphs
            because they are required
        */

            let customerSnakeIdTextField = document.getElementById("customerSnakeId");
            const customerSnakeIdErrorLabel = "customerSnakeIdErrorLabel";
            let customerSnakeIdEmpty = checkTextFieldEmpty(customerSnakeIdTextField, customerSnakeIdErrorLabel, "Customer snake ID is required");

            let knownMorphLabel = document.getElementById(MorphLabelClasses.KnownMorph);
            deleteEmptyMorphTextFields(MorphInputClass.KnownMorph, knownMorphLabel);

            let possibleMorphLabel = document.getElementById(MorphLabelClasses.PossibleMorph);
            deleteEmptyMorphTextFields(MorphInputClass.PossibleMorph, possibleMorphLabel);

            let testMorphLabel = document.getElementById(MorphLabelClasses.TestMorph);
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
            let lastTestMorphTextField = getLastElementOfHtmlCollection(
                document.getElementsByClassName(MorphInputClass.TestMorph)
            );
            addOrRemoveMorphErrorLabel(lastTestMorphTextField ?? testMorphLabelPlacement, testMorphTextFieldsEmpty, testMorphErrorLabel, "At least one tested morph is required");


            /*
                Check whether known morphs, possible morphs or tested morphs contain duplicates
                because there can't be two of the same morphs in known morphs
            */

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


            /*
                Check whether there are duplicates between known and possible morphs
                because a plausible snake morph cannot also be a known morph
            */
            let knownMorphInputs = document.getElementsByClassName(MorphInputClass.KnownMorph);
            let possibleMorphInputs = document.getElementsByClassName(MorphInputClass.PossibleMorph);
            let duplicatesExistBetweenKnownPossibleMorphs = areThereDuplicatesBetweenHtmlCollectionsValues(knownMorphInputs, possibleMorphInputs);

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

            if(
                customerSnakeIdEmpty
                || testMorphTextFieldsEmpty
                || knownMorphsContainDuplicates
                || possibleMorphsContainDuplicates
                || testMorphsContainDuplicates
                || duplicatesExistBetweenKnownPossibleMorphs
            ) {
                submitEvent.preventDefault();
            }
        }
        else {
            submitEvent.preventDefault();
        }
    });
}