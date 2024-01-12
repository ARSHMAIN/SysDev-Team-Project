<?php

enum MorphError: string {
    /*
        Enumeration of all errors that happen when a morph does not exist
        in the database
    */
    case KnownMorphNonexistent = "knownMorphNonexistent";
    case PossibleMorphNonexistent = "possibleMorphNonexistent";
    case TestMorphNonexistent = "testMorphNonexistent";
}