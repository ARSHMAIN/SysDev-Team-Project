<?php

namespace MyApp\Controllers;

use Core\Controller;
use MyApp\Models\Morph;
class ServicesController extends Controller
{
    function services(): void
    {
        $testedMorphs = Morph::getByIsTested(true);
//            print_r($testedMorphs);
        $this->render();
    }
}