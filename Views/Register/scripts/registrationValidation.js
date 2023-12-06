document.addEventListener("DOMContentLoaded", setUpEventHandlers);


function setUpEventHandlers() {
    setUpSignUpClickEvent();
}

function setUpSignUpClickEvent() {
    var registrationForm = document.getElementsByTagName("form")[0];

    registrationForm.addEventListener("submit", function(formSubmitEvent) {
        var firstNameTextField = document.getElementsByName("firstName")[0];
        var firstNameIsEmpty = checkTextFieldEmpty(firstNameTextField, "firstNameErrorLabel", "First name is empty");

        var lastNameTextField = document.getElementsByName("lastName")[0];
        var lastNameIsEmpty = checkTextFieldEmpty(lastNameTextField, "lastNameErrorLabel", "Last name is empty");


        var emailTextField = document.getElementsByName("email")[0];
        var emailTextFieldIsEmpty = checkTextFieldEmpty(emailTextField, "emailErrorLabel", "Email is empty");

        var passwordTextField = document.getElementsByName("password")[0];
        var passwordTextFieldIsEmpty = checkTextFieldEmpty(passwordTextField, "passwordErrorLabel", "Password is empty");


        if(firstNameIsEmpty
            || lastNameIsEmpty
            || emailTextFieldIsEmpty
            || passwordTextFieldIsEmpty
        ) {
            formSubmitEvent.preventDefault();
        }
    });
}
