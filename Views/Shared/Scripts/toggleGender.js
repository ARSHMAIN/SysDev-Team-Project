function toggleGender() {
    // Remove the 'selected' class from all images
    maleImage.classList.remove('selected');
    femaleImage.classList.remove('selected');
    unknownImage.classList.remove('selected');

    // Add the 'selected' class to the clicked image
    this.classList.add('selected');
}