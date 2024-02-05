document.addEventListener("DOMContentLoaded", setUpEventHandlers);

function setUpEventHandlers() {
    setUpEditProfileEventHandler();
}

function setUpEditProfileEventHandler() {
    const editProfileForm = document.getElementsByClassName("editProfileForm")[0];

    editProfileForm.addEventListener("submit", function(submitEvent) {
        let insensitiveUserInformationValidationResults = validateInsensitiveUserInformation();
        let userAddressValidationResults = validateUserAddressInformation();

        if(
            insensitiveUserInformationValidationResults.FirstNameIsEmpty
            || insensitiveUserInformationValidationResults.LastNameIsEmpty
            || userAddressValidationResults.StreetNumberIsEmpty
            || userAddressValidationResults.StreetNameIsEmpty
            || userAddressValidationResults.CityIsEmpty
            || userAddressValidationResults.PostalCodeIsEmpty
            || userAddressValidationResults.CountryIsEmpty
        ) {
            submitEvent.preventDefault();
        }
    });
}

function validateInsensitiveUserInformation() {
    let firstNameTextField = document.getElementsByName("firstName")[0];
    let firstNameLabel = document.getElementsByClassName("firstNameLabel")[0];
    let firstNameIsEmpty= validateTextFieldEmpty(
        firstNameTextField,
        firstNameLabel,
        "firstNameEmptyErrorLabel",
        "First name is empty"
    );

    let lastNameTextField = document.getElementsByName("lastName")[0];
    let lastNameLabel = document.getElementsByClassName("lastNameLabel")[0];
    let lastNameIsEmpty = validateTextFieldEmpty(
        lastNameTextField,
        lastNameLabel,
        "lastNameEmptyErrorLabel",
        "Last name is empty"
    );

    return {
        FirstNameIsEmpty : firstNameIsEmpty,
        LastNameIsEmpty: lastNameIsEmpty
    };
}

function validateUserAddressInformation() {
    let streetNumberTextField = document.getElementsByName("streetNumber")[0];
    let streetNumberLabel = document.getElementsByClassName("streetNumberLabel")[0];
    let streetNumberIsEmpty = validateTextFieldEmpty(
        streetNumberTextField,
        streetNumberLabel,
        "streetNumberEmptyErrorLabel",
        "Street number is empty"
    );

    let streetNameTextField = document.getElementsByName("streetName")[0];
    let streetNameLabel = document.getElementsByClassName("streetNameLabel")[0];
    let streetNameIsEmpty = validateTextFieldEmpty(
        streetNameTextField,
        streetNameLabel,
        "streetNameEmptyErrorLabel",
        "Street name is empty"
    );

    let cityTextField = document.getElementsByName("city")[0];
    let cityLabel = document.getElementsByClassName("cityLabel")[0];
    let cityIsEmpty = validateTextFieldEmpty(
        cityTextField,
        cityLabel,
        "cityEmptyErrorLabel",
        "City is empty"
    );

    let postalCodeTextField = document.getElementsByName("postalCode")[0];
    let postalCodeLabel = document.getElementsByClassName("postalCodeLabel")[0];
    let postalCodeIsEmpty = validateTextFieldEmpty(
        postalCodeTextField,
        postalCodeLabel,
        "postalCodeEmptyErrorLabel",
        "Postal code is empty"
    );

    let countryTextField = document.getElementsByName("country")[0];
    let countryLabel = document.getElementsByClassName("countryLabel")[0];
    let countryIsEmpty = validateTextFieldEmpty(
        countryTextField,
        countryLabel,
        "countryEmptyErrorLabel",
        "Country is empty"
    );

    return {
        StreetNumberIsEmpty : streetNumberIsEmpty,
        StreetNameIsEmpty : streetNameIsEmpty,
        CityIsEmpty : cityIsEmpty,
        PostalCodeIsEmpty : postalCodeIsEmpty,
        CountryIsEmpty : countryIsEmpty
    };
}