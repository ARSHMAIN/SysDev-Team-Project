document.addEventListener("DOMContentLoaded", setUpEventHandlers);

function setUpEventHandlers() {
    setUpSubmitEventHandler();
}

function setUpSubmitEventHandler() {
    // Prevent the form from submitting if the email or the password text field is empty
    let editEmailForm = document.getElementsByClassName("editEmail")[0];

    editEmailForm.addEventListener("submit", function(submitEvent) {
       let emailTextField = document.getElementsByName("newEmailAddress")[0];
       let emailTextLabel = document.getElementsByName("newEmailAddressLabel")[0];

       let passwordTextField = document.getElementsByName("password")[0];
       let passwordTextLabel = document.getElementsByName("passwordLabel")[0];

       let emailTextFieldEmpty = checkTextFieldEmpty(emailTextField);
       addOrRemoveErrorLabel(
           emailTextField ?? emailTextLabel,
            emailTextFieldEmpty,
           "newEmailAddressErrorLabel",
           "New email address is empty"
       );

       let passwordTextFieldEmpty = checkTextFieldEmpty(passwordTextField);
       addOrRemoveErrorLabel(
           passwordTextField ?? passwordTextLabel,
           passwordTextFieldEmpty,
           "passwordErrorLabel",
           "Password is empty"
       );

       if(emailTextFieldEmpty
           || passwordTextFieldEmpty
       ) {
           submitEvent.preventDefault();
       }
    });
}