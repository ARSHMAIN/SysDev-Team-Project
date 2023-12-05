function addInput(insertClass) {
    const inputsCount = document.querySelectorAll(`.${insertClass}`).length;
    console.log(insertClass)
    let insertId = `${insertClass}${inputsCount}`;
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
        const label = document.querySelector(`#${insertClass}Label`);
        const element = label.nextElementSibling.nextElementSibling.nextElementSibling
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
