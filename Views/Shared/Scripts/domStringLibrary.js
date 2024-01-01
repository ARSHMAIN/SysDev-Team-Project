function getInnerHtmlOfElements(htmlElements) {
    /*
        Gets the inner html of an HTML collection of elements
    */
    var innerHtmlArray = [];

    for(var htmlEleIndex = 0; htmlEleIndex < htmlElements.length; ++htmlEleIndex) {
        innerHtmlArray.push(htmlElements[htmlEleIndex].innerHTML);
    }
    return innerHtmlArray;
}