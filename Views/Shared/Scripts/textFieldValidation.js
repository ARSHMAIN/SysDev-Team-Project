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
    var errorLabelTextDiv = createErrorLabel(errorLabelIdentifier, errorLabelText);

    textField.insertAdjacentElement("afterend", errorLabelTextDiv);
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



