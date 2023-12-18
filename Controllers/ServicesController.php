<?php
include_once 'Views/Shared/session.php';
include_once 'Models/Morph.php';
class ServicesController
{
    function route(): void
    {
        global $action;
        if ($action == "services"){
            $testedMorphs = Morph::getByIsTested(true);
//            print_r($testedMorphs);
            $this->render($action);
        }
    }
    function render($action, $data = []): void
    {
        extract($data);
        include_once "Views/Services/$action.php";
    }
}