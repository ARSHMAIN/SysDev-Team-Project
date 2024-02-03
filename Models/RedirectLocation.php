<?php
enum RedirectLocation : string {
    /*
        Enumeration of all error redirect locations used for
        ValidationHelper::checkErrorExists redirect location
    */
    case CreateTest = "?controller=order&action=test";
    case UpdateTest = "?controller=order&action=updateTest&id=";
    case Registration = "?controller=registration&action=registration";
    case Login = "?controller=login&action=login";

    case EditProfile = "?controller=user&action=editProfile";
    case EditEmail = "?controller=user&action=editEmail";
    case ActivateAccount = "?controller=user&action=activateAccount";
    case Home = "?controller=home&action=home";
    case SuccessEditEmail = "?controller=user&action=successEditEmail";
    case Contact = "?controller=contact&action=contact";

}