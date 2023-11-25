function addInput(submit) {
    const inputsCount = form.querySelectorAll('input').length;
    const input = document.createElement('input');
    input.setAttribute('id', `morph${inputsCount}`);
    input.setAttribute('type', 'text');
    input.setAttribute('name', `morph${inputsCount}`);
    submit.insertAdjacentElement('beforebegin', input);
}

function removeInput(submit) {
    const previousElement = submit.previousElementSibling;
    if (previousElement) {
        previousElement.remove();
    }
}

//TODO search, search dropdown js