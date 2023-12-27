<?php
class ServicesController extends Controller
{
    function services(): void
    {
        $testedMorphs = Morph::getByIsTested(true);
//            print_r($testedMorphs);
        $this->render();
    }
}