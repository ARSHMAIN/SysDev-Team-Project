function checkTextFieldEmpty(textField, errorLabelIdentifier, errorLabelText = "") {
    var textFieldValue = textField.value;
    var textFieldIsEmpty = false;
    if(textField.value.trim().length === 0) {
        textFieldIsEmpty = true;
        if(!checkErrorLabelExists(errorLabelIdentifier)) {
            addLoginErrorLabel(textField, errorLabelIdentifier, errorLabelText);
        }
    }
    else {
        removeErrorLabel(errorLabelIdentifier);
    }

    return textFieldIsEmpty;
}

function addLoginErrorLabel(textField, errorLabelIdentifier, errorLabelText = "") {
    var errorLabelTextDiv = createErrorLabel(errorLabelIdentifier, errorLabelText);

    /*Insert an error input label after the login input text field's div
        Because textField might return null, that is fine because it will implicitly add the node to the end of a parent node
     */
    var loginInputDiv = textField.parentNode;
    loginInputDiv.insertBefore(errorLabelTextDiv, textField.nextSibling);
}


function addMorphErrorLabel(textField, errorLabelIdentifier, errorLabelText = "") {
    /*
        Add error label if it does not exist yet
    */
    var errorLabelExists = checkErrorLabelExists(errorLabelIdentifier);
    if(!errorLabelExists) {
        var errorLabelTextDiv = createErrorLabel(errorLabelIdentifier, errorLabelText);
        textField.insertAdjacentElement("afterend", errorLabelTextDiv);
    }
}

function checkErrorLabelExists(errorLabelIdentifier) {
    var errorLabelDiv = document.getElementsByClassName(errorLabelIdentifier)[0];
    var errorLabelExists = false;
    /*
        We check if the error label exists before adding one because we do not want duplicates of the error label
    */
    if(errorLabelDiv) {
        errorLabelExists = true;
    }
    return errorLabelExists;
}

function removeErrorLabel(errorLabelIdentifier) {
    var errorLabelExists = checkErrorLabelExists(errorLabelIdentifier);
    if(errorLabelExists) {
        var errorLabelDiv = document.getElementsByClassName(errorLabelIdentifier)[0];
        errorLabelDiv.remove();
    }

}

function createErrorLabel(errorLabelIdentifier, errorLabelText = "") {
    var errorLabelTextDiv = document.createElement("div");
    errorLabelTextDiv.classList.add("errorLabelText");
    /*Add an identifier to the error label because we want to be able to delete
      this div later
    */
    errorLabelTextDiv.classList.add(errorLabelIdentifier);

    var errorLabel = document.createElement("label");
    errorLabel.innerHTML = errorLabelText;
    errorLabelTextDiv.appendChild(errorLabel);

    return errorLabelTextDiv;
}

    function addOrRemoveMorphErrorLabel(htmlElement, shouldAddErrorLabel, morphErrorLabelIdentifier, morphErrorLabelText) {
    /*
        Determine whether an error label should be added or removed based on "shouldAddErrorLabel" boolean
    */

    if(shouldAddErrorLabel) {
        addMorphErrorLabel(htmlElement, morphErrorLabelIdentifier, morphErrorLabelText);
    }
    else {
        removeErrorLabel(morphErrorLabelIdentifier);
    }
}

function deleteEmptyMorphTextFields(morphClassName, elementToAddAfter, keepOneTextField = false) {
    /*
        Check whether morph text fields are empty
    */
    let morphInputElements = document.getElementsByClassName(morphClassName);

    let morphTextFieldsEmpty = true;
    if(!keepOneTextField) {
        morphTextFieldsEmpty = deleteEmptyTextFields(morphInputElements);
    }
    else {
        morphTextFieldsEmpty = keepOneEmptyTextField(morphInputElements, elementToAddAfter, morphClassName);
    }
    return morphTextFieldsEmpty;
}

function deleteEmptyTextFields(elementHtmlCollection) {
    let morphTextFieldsEmpty = true;
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

function keepOneEmptyTextField(elementHtmlCollection, elementToAddAfter, morphClassName) {
    /*
        Make sure at least one empty text field is present on the create/update test page
        for better user experience.
    */
    let morphTextFieldsEmpty = true;

    if(elementHtmlCollection.length > 0) {

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
    }
    else {
        let morphInputTextField = createMorphInputTextField(morphClassName);
        elementToAddAfter.insertAdjacentElement("afterend", morphInputTextField);
        let lineBreak = document.createElement("br");
        elementToAddAfter.insertAdjacentElement("afterend", lineBreak);
    }

    return morphTextFieldsEmpty;
}

function createMorphInputTextField(morphClassName) {
    let morphInputTextField = document.createElement("input");
    morphInputTextField.setAttribute("type", "text");
    morphInputTextField.classList.add(morphClassName);
    morphInputTextField.setAttribute("name", morphClassName + "[]");
    morphInputTextField.setAttribute("id", morphClassName);

    return morphInputTextField;
}

function checkMorphDuplicates(morphClassName) {
    /*
        Get the values of text fields and check whether there are duplicates
        Gets the text fields by class name
    */
    const morphInputElements = getValueOfInputElements(document.getElementsByClassName(morphClassName));
    const uniqueMorphElements = new Set(morphInputElements);


    /*
        Creating a set will find the unique elements inside the morph inputs,
        and if the array
    */
    let duplicatesExist = uniqueMorphElements.size !== morphInputElements.length;
    return duplicatesExist;
}


