function addInput(insertClass) {
    /*
        Count the number of inputs because we want to set the ID of the new input element to the current
        number of input elements + 1
    */
    const inputsCount = document.querySelectorAll(`.${insertClass}`).length;
    console.log(insertClass);
    let insertId = `${insertClass}${inputsCount}`;
    /*
        Select the last input element for a certain class (knownMorph, possibleMorph or testMorph)
        because we want to insert an input element and a line break element after that last input element
    */
    const insertBeforeElement = document.querySelector(`#${insertId}`);
    const input = document.createElement('input');
    const lineBreak = document.createElement('br');
    insertId = `${insertClass}${inputsCount + 1}`;
    input.setAttribute('class', `${insertClass}`);
    input.setAttribute('id', `${insertId}`);
    input.setAttribute('type', 'text');
    input.setAttribute('name', `${insertId}`);
    // input.setAttribute('required', 'required');
    if (insertBeforeElement) {
        insertBeforeElement.insertAdjacentElement('afterend', input);
        insertBeforeElement.insertAdjacentElement('afterend', lineBreak);
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
    const inputsCount = document.querySelectorAll(`.${deleteElementClass}`).length;
    let deleteElementId = `${deleteElementClass}${inputsCount}`;
    const element = document.querySelector(`#${deleteElementId}`)
    if (element) {
        element.previousElementSibling.remove()
        element.remove();
    }
}
