function addInput(insertClass) {
    /*
        Count the number of inputs because we want to set the ID of the new input element to the current
        number of input elements + 1
    */
    const morphInputs = document.querySelectorAll(`.${insertClass}`);
    let lastMorphInput = morphInputs[morphInputs.length - 1];

    /*
        Select the last input element for a certain class (knownMorph, possibleMorph or testMorph)
        because we want to insert an input element and a line break element after that last input element
    */
    const input = document.createElement('input');
    const lineBreak = document.createElement('br');
    input.setAttribute('class', `${insertClass}`);
    input.setAttribute('id', `${insertClass}`);
    input.setAttribute('type', 'text');
    input.setAttribute('name', `${insertClass}[]`);
    // input.setAttribute('required', 'required');
    if (lastMorphInput) {
        lastMorphInput.insertAdjacentElement('afterend', input);
        lastMorphInput.insertAdjacentElement('afterend', lineBreak);
    } else {
        /*
            If there are no input elements, add an input element after the add and remove buttons for that
            respective category, such as knownMorph, possibleMorph or testMorph (the add and remove input element buttons)
        */
        const label = document.querySelector(`#${insertClass}Label`);
        const element = label.nextElementSibling.nextElementSibling.nextElementSibling;
        element.insertAdjacentElement('afterend', input);
        element.insertAdjacentElement('afterend', lineBreak);
    }
}

function removeInput(deleteElementClass) {
    const morphInputs = document.querySelectorAll(`.${deleteElementClass}`);
    let lastMorphInput = morphInputs[morphInputs.length - 1];
    if (lastMorphInput) {
        /*
            Remove line break and last input
        */
        lastMorphInput.previousElementSibling.remove();
        lastMorphInput.remove();
    }
}
