document.addEventListener("DOMContentLoaded", setUpEventHandlers);


function setUpEventHandlers() {
    // setUpSignUpClickEvent();
}

function setUpSignUpClickEvent() {
    const loginForm = document.getElementById("login");

    loginForm.addEventListener("submit", function(formSubmitEvent) {
        const emailTextField = document.getElementsByName("email")[0];
        const emailLabel = document.getElementsByClassName("emailLabel")[0];
        const emailIsEmpty = checkTextFieldEmpty(emailTextField);
        addOrRemoveLoginRegisterErrorLabel(
          emailTextField ?? emailLabel,
          emailIsEmpty,
          "emailErrorLabel",
          "Email is empty"
        );

        const passwordTextField = document.getElementsByName("password")[0];
        const passwordLabel = document.getElementsByClassName("passwordLabel")[0];
        const passwordIsEmpty = checkTextFieldEmpty(passwordTextField);
        /*
            We fall back to a password label in case the user deletes the text field using inspect element
            in which case the error will still appear
            The error will not appear if the user deletes both labels and input text fields
            and the form will not be submitted
        */
        addOrRemoveLoginRegisterErrorLabel(
            passwordTextField ?? passwordLabel,
            passwordIsEmpty,
            "passwordErrorLabel",
            "Password is empty"
        );

        if(emailIsEmpty
            || passwordIsEmpty
        ) {
            formSubmitEvent.preventDefault();
        }
    });
}