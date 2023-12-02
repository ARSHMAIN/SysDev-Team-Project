function toggleGender() {
    // Remove the 'selected' class from all images
    maleImage.classList.remove('selected');
    femaleImage.classList.remove('selected');
    unknownImage.classList.remove('selected');

    // Add the 'selected' class to the clicked image
    this.classList.add('selected');
    hiddenGender.value = findUpperCase(this.id);
}

function findUpperCase(string) {
    let newString;
    for (let i = 0; i < string.length; i++) {
        if (string[i] === string[i].toUpperCase()) {
            newString = string.slice(0, i);
            break;
        }
    }
    return newString;
}