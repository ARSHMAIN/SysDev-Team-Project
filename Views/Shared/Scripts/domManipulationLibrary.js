function getValueOfInputElements(inputElements) {
    /*
        Gets the inner html of an HTML collection of elements
    */
    let valueArray = [];

    for(let inputEleIndex = 0; inputEleIndex < inputElements.length; ++inputEleIndex) {
        valueArray.push(inputElements[inputEleIndex].value);

    }

    return valueArray;
}

function getLastElementOfHtmlCollection(htmlElements) {
    let lastHtmlElement = htmlElements[htmlElements.length - 1];
    return lastHtmlElement;
}

