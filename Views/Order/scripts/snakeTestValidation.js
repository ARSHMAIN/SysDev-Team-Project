function performDuplicateChecks() {
    let knownMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.KnownMorph);
    const dupKnownMorphErrorLabel = "dupKnownMorphErrorLabel";
    let lastKnownMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.KnownMorph)
    );

    addOrRemoveMorphErrorLabel(
        lastKnownMorphTextField,
        knownMorphsContainDuplicates,
        dupKnownMorphErrorLabel,
        "Known morphs cannot contain duplicates");


    const possibleMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.PossibleMorph);
    const dupPossibleMorphErrorLabel = "dupPossibleMorphErrorLabel";
    let lastPossibleMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.PossibleMorph)
    );

    addOrRemoveMorphErrorLabel(
        lastPossibleMorphTextField,
        possibleMorphsContainDuplicates,
        dupPossibleMorphErrorLabel,
        "Possible morphs cannot contain duplicates");


    let testMorphsContainDuplicates = false;
    testMorphsContainDuplicates = checkMorphDuplicates(MorphInputClass.TestMorph);
    const dupTestMorphErrorLabel = "dupTestMorphErrorLabel";
    const lastTestMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.TestMorph)
    );
    addOrRemoveMorphErrorLabel(
        lastTestMorphTextField,
        testMorphsContainDuplicates,
        dupTestMorphErrorLabel,
        "Tested morphs cannot contain duplicates"
    );

    const duplicateValidationResults = {
        KnownMorphsContainDuplicates: knownMorphsContainDuplicates,
        PossibleMorphsContainDuplicates: possibleMorphsContainDuplicates,
        TestMorphsContainDuplicates: testMorphsContainDuplicates
    };
    return duplicateValidationResults;
}

function performDuplicateChecksBetweenKnownPossibleMorphs() {
    /*
        Check whether there are morphs in known morphs and possible morphs at the same time
        because they cannot exist in both categories
    */
    let knownMorphInputs = document.getElementsByClassName(MorphInputClass.KnownMorph);
    let possibleMorphInputs = document.getElementsByClassName(MorphInputClass.PossibleMorph);

    let duplicatesExistBetweenKnownPossibleMorphs = areThereDuplicatesBetweenHtmlCollectionsValues(knownMorphInputs, possibleMorphInputs);
    console.log(duplicatesExistBetweenKnownPossibleMorphs);
    let lastKnownMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.KnownMorph)
    );
    let lastPossibleMorphTextField = getLastElementOfHtmlCollection(
        document.getElementsByClassName(MorphInputClass.PossibleMorph)
    );

    const dupBetweenKnownMorphErrorLabel = "dupBetweenKnownMorphErrorLabel";
    const dupBetweenPossibleMorphErrorLabel = "dupBetweenPossibleMorphErrorLabel";
    addOrRemoveMorphErrorLabel(
        lastKnownMorphTextField,
        duplicatesExistBetweenKnownPossibleMorphs,
        dupBetweenKnownMorphErrorLabel,
        "Duplicate morphs between known and possible morphs");
    addOrRemoveMorphErrorLabel(
        lastPossibleMorphTextField,
        duplicatesExistBetweenKnownPossibleMorphs,
        dupBetweenPossibleMorphErrorLabel,
        "Duplicate morphs between known and possible morphs"
    );


    return duplicatesExistBetweenKnownPossibleMorphs;
}
