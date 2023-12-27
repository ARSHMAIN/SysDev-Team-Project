<?php
include_once 'Core/Controller.php';
include_once 'Models/Morph.php';
class ServicesController extends Controller
{
    function services(): void
    {
        $testedMorphs = Morph::getByIsTested(true);
//            print_r($testedMorphs);
        $this->render();
    }
}