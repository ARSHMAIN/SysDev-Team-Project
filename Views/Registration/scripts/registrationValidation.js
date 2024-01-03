document.addEventListener("DOMContentLoaded", setUpEventHandlers);


function setUpEventHandlers() {
    setUpSignUpClickEvent();
}

function setUpSignUpClickEvent() {
    let registrationForm = document.getElementById("registration");

    registrationForm.addEventListener("submit", function(formSubmitEvent) {
        formSubmitEvent.preventDefault();
        const firstNameTextField = document.getElementsByName("firstName")[0];
        const firstNameLabel = document.getElementsByClassName("firstNameLabel")[0];
        const firstNameIsEmpty = checkTextFieldEmpty(firstNameTextField);
        addOrRemoveLoginRegisterErrorLabel(
            firstNameTextField ?? firstNameLabel,
            firstNameIsEmpty,
            "firstNameErrorLabel",
            "First name is empty"
        );

        const lastNameTextField = document.getElementsByName("lastName")[0];
        const lastNameLabel = document.getElementsByClassName("lastNameLabel")[0];
        const lastNameIsEmpty = checkTextFieldEmpty(lastNameTextField);
        addOrRemoveLoginRegisterErrorLabel(
          lastNameTextField ?? lastNameLabel,
          lastNameIsEmpty,
          "lastNameErrorLabel",
          "Last name is empty"
        );


        const emailTextField = document.getElementsByName("email")[0];
        const emailLabel = document.getElementsByClassName("emailLabel")[0];
        const emailTextFieldIsEmpty = checkTextFieldEmpty(emailTextField);
        addOrRemoveLoginRegisterErrorLabel(
          emailTextField ?? emailLabel,
          emailTextFieldIsEmpty,
          "emailErrorLabel",
            "Email is empty"
        );


        const passwordTextField = document.getElementsByName("password")[0];
        const passwordLabel = document.getElementsByClassName("passwordLabel")[0];
        const passwordTextFieldIsEmpty = checkTextFieldEmpty(passwordTextField);
        addOrRemoveLoginRegisterErrorLabel(
          passwordTextField ?? passwordLabel,
          passwordTextFieldIsEmpty,
          "passwordErrorLabel",
          "Password is empty"
        );

        if(firstNameIsEmpty
            || lastNameIsEmpty
            || emailTextFieldIsEmpty
            || passwordTextFieldIsEmpty
        ) {
            formSubmitEvent.preventDefault();
        }
    });
}
