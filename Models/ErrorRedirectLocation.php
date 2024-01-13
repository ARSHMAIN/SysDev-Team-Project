<?php
enum ErrorRedirectLocation : string {
    /*
        Enumeration of all error redirect locations used for
        ValidationHelper::checkErrorExists redirect location
    */
    case CreateTest = "?controller=order&action=test";
    case UpdateTest = "?controller=order&action=updateTest&id=";

}