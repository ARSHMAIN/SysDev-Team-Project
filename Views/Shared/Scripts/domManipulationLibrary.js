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

function getInnerHtmlOfElements(htmlElements) {
    /*
        Gets the inner html of an HTML collection of elements
    */
    let innerHtmlArray = [];

    for(let htmlEleIndex = 0; htmlEleIndex < htmlElements.length; ++htmlEleIndex) {
        innerHtmlArray.push(htmlElements[htmlEleIndex].innerHTML);
    }
    return innerHtmlArray;
}

function getLastElementOfHtmlCollection(htmlElements) {
    return htmlElements[htmlElements.length - 1];
}

function strToLowerArray(strArray) {
    /*
        Returns a lowercase array by iterating through each array item and
        converting it to lowercase
    */
    return strArray.map(function (strArrayItem) {
        return strArrayItem.toLowerCase();
    });
}

