<?php
    enum MorphInputClass : string {
        /* Enumeration of all class names for input text fields in the create/update
            test section
        */
        case KnownMorph = "knownMorph";
        case PossibleMorph = "possibleMorph";
        case TestMorph = "testMorph";
    }
