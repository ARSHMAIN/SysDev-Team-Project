document.addEventListener("DOMContentLoaded", setUpEventHandlers);


function setUpEventHandlers() {
    setUpSignUpClickEvent();
}

function setUpSignUpClickEvent() {
    var loginForm = document.getElementsByTagName("form")[0];

    loginForm.addEventListener("submit", function(formSubmitEvent) {
        var emailTextField = document.getElementsByName("email")[0];
        var emailIsEmpty = checkTextFieldEmpty(emailTextField, "emailErrorLabel", "Email is empty");

        var passwordTextField = document.getElementsByName("password")[0];
        var passwordIsEmpty = checkTextFieldEmpty(passwordTextField, "passwordErrorLabel", "Password is empty");



        if(emailIsEmpty
            || passwordIsEmpty
        ) {
            formSubmitEvent.preventDefault();
        }
    });
}