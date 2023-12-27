const addBtnKnownMorph = document.getElementById('addBtnKnownMorph');
const addBtnPossibleMorph = document.getElementById('addBtnPossibleMorph');
const addBtnTestMorph = document.getElementById('addBtnTestMorph');

const removeBtnKnownMorph = document.getElementById('removeBtnKnownMorph');
const removeBtnPossibleMorph = document.getElementById('removeBtnPossibleMorph');
const removeBtnTestMorph = document.getElementById('removeBtnTestMorph');

addBtnKnownMorph.addEventListener('click', () => addInput('knownMorph'));
addBtnPossibleMorph.addEventListener('click', () => addInput('possibleMorph'));
addBtnTestMorph.addEventListener('click', () => addInput('testMorph'));
removeBtnKnownMorph.addEventListener('click', () => removeInput('knownMorph'));
removeBtnPossibleMorph.addEventListener('click', () => removeInput('possibleMorph'));
removeBtnTestMorph.addEventListener('click', () => removeInput('testMorph'));

// const maleImage = document.getElementById('maleGender');
// const femaleImage = document.getElementById('femaleGender');
// const unknownImage = document.getElementById('unknownGender');
// const hiddenGender = document.getElementById('sex');
//
// maleImage.addEventListener('click', toggleGender);
// femaleImage.addEventListener('click', toggleGender);
// unknownImage.addEventListener('click', toggleGender);


