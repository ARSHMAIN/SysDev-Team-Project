document.addEventListener("DOMContentLoaded", setUpEventHandlers);


function setUpEventHandlers() {
    setUpSignUpClickEvent();
}

function setUpSignUpClickEvent() {
    var signUpButton = document.getElementsByName("submit")[0];
    signUpButton.addEventListener("click", checkRegistrationTextFields)
}

function checkRegistrationTextFields() {

}