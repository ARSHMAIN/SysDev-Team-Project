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
        var knownMorphTextFieldsEmpty = areMorphTextFieldsEmpty(MorphInputClass.KnownMorph);
        var possibleMorphTextFieldsEmpty = areMorphTextFieldsEmpty(MorphInputClass.PossibleMorph);
        var testMorphTextFieldsEmpty = areMorphTextFieldsEmpty(MorphInputClass.TestMorph, true);


        const testMorphErrorLabel = "testMorphErrorLabel";
        var testMorphErrorLabelDiv = document.getElementsByClassName(testMorphErrorLabel);
        if(testMorphTextFieldsEmpty) {
            let testMorphTextFields = document.getElementsByClassName(MorphInputClass.TestMorph);
            let lastTestMorphTextField = testMorphTextFields[testMorphTextFields.length - 1];
            if(testMorphErrorLabelDiv.length === 0) {
                addMorphErrorLabel(lastTestMorphTextField, testMorphErrorLabel, "One tested morph is required");
            }
        }
        else {
            if(testMorphErrorLabelDiv.length > 0) {
                removeErrorLabel(testMorphErrorLabelDiv);
            }
        }


        var knownMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.KnownMorph);
        var possibleMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.PossibleMorph);
        var testMorphsTextContainDuplicates = checkMorphDuplicates(MorphInputClass.TestMorph);
        // if(knownMorphsContainDuplicates) {
        //     addLoginErrorLabel();
        // }
    });
}

function areMorphTextFieldsEmpty(morphClassName, keepOneTextField = false) {
    let morphInputElements = document.getElementsByClassName(morphClassName);

    let morphTextFieldsEmpty = false;
    if(!keepOneTextField) {

        morphTextFieldsEmpty = deleteEmptyTextFields(morphInputElements);
    }
    else {
        morphTextFieldsEmpty = keepOneEmptyTextField(morphInputElements);

    }
    return morphTextFieldsEmpty;
}

function deleteEmptyTextFields(elementHtmlCollection) {
    let morphTextFieldsEmpty = false;
    for(var inputEleIndex = elementHtmlCollection.length - 1, filledMorphFound = false; inputEleIndex >= 0; --inputEleIndex) {
        if(elementHtmlCollection[inputEleIndex].value.length === 0) {
            elementHtmlCollection[inputEleIndex].remove();
            if(!filledMorphFound) {
                morphTextFieldsEmpty = true;
            }
        }
        else {
            filledMorphFound = true;
            morphTextFieldsEmpty = false;
        }
    }



    return morphTextFieldsEmpty;
}

function keepOneEmptyTextField(elementHtmlCollection) {
    let morphTextFieldsEmpty = false;


    for(let inputEleIndex = elementHtmlCollection.length - 1, filledTextFieldFound = false; inputEleIndex >= 0; --inputEleIndex) {

        if(elementHtmlCollection[inputEleIndex].value.length > 0) {
            // If the current text field contains characters, just leave it
            morphTextFieldsEmpty = false;
            filledTextFieldFound = true;
            continue;
        }


        if(elementHtmlCollection[inputEleIndex].value.length === 0 && (inputEleIndex - 1 === -1) && !filledTextFieldFound) {
            // Don't delete the empty text field because the next one does not exist
            // We do this because this text field is required (e.g.: tested morphs)
            // Unless there was a filled text field found
            morphTextFieldsEmpty = true;
        }
        else if(elementHtmlCollection[inputEleIndex].value.length === 0) {
            // If the text field is empty, and is before the last text field in the collection,
            // Delete it
            elementHtmlCollection[inputEleIndex].remove();
            if(!filledTextFieldFound) {
                morphTextFieldsEmpty = true;
            }
        }
    }

    return morphTextFieldsEmpty;
}

function checkMorphDuplicates(morphClassName) {
    const morphInputElements = getInnerHtmlOfElements(document.getElementsByClassName(morphClassName));
    const uniqueMorphElements = new Set(morphInputElements);

    /*
        Creating a set will find the unique elements inside the morph inputs,
        and if the array
    */
    let duplicatesExist = uniqueMorphElements.length !== morphInputElements.length;
    return duplicatesExist;
}


// const maleImage = document.getElementById('maleGender');
// const femaleImage = document.getElementById('femaleGender');
// const unknownImage = document.getElementById('unknownGender');
// const hiddenGender = document.getElementById('sex');
//
// maleImage.addEventListener('click', toggleGender);
// femaleImage.addEventListener('click', toggleGender);
// unknownImage.addEventListener('click', toggleGender);


