const form = document.querySelector('form[id="order"]');
const addBtn = document.getElementById('addBtn');
const removeBtn = document.getElementById('removeBtn');
// The element that's used for inserting/deleting before it
const submit = document.getElementById('submit');

addBtn.addEventListener('click', () => addInput(submit));
removeBtn.addEventListener('click', () => removeInput(submit));

const maleImage = document.getElementById('maleGender');
const femaleImage = document.getElementById('femaleGender');
const unknownImage = document.getElementById('unknownGender');

maleImage.addEventListener('click', toggleGender);
femaleImage.addEventListener('click', toggleGender);
unknownImage.addEventListener('click', toggleGender);

