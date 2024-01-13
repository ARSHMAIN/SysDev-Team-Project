<?php
    class ValidationHelper {
        public static function isPostDataAccepted(array $allowedPosts, array $postArray): bool {
            /*
                Determine whether POST data is accepted (the keys of the POST array aka the name attribute)
                allowedPosts is an array of allowed name attributes
                postArray is the $_POST array
                As soon as a value is denied, the function returns that the POST data is denied.
            */

            // If the count of POST array is 1, reject it because it only contains submit button or
            // if the count of POST array keys is greater than the number of keys allowed in POST array
            // ($allowedPosts) then the POST data is not accepted
            if(
                (count($postArray) > count($allowedPosts))
                || count($postArray) == 1
            ) {
                // If the POST array is empty or the count of
                // POST keys is larger than the count of the array of allowed POSTS,
                // Then return that the POST data is denied because the post array cannot be of size 0
                // or the post array must not contain a greater amount of keys than what is allowed
                return false;
            }

            $intersectedArray = array_intersect($allowedPosts, array_keys($postArray));
            /*
             * Check whether the length of the intersected array between allowed POSTS and the POST array
             * sent through the parameters because we want to check whether any item was denied
             * If an item is denied, the intersected array length would be less than the post array's length
            */
            $postDataAccepted = count($intersectedArray) == count($postArray);
            return $postDataAccepted;
        }

        public static function isPostDataRequired(array $requiredPosts, array $postArray) : bool {
            /*
                Check whether the POST data sent contains the data required
            */
            $intersectedArray = array_intersect($requiredPosts, array_keys($postArray));

            /*
             * Check whether the intersected array between required POSTS and the POST array
             * sent through the parameters because we want to check if all the required items are there
            */
            $postDataRequired = count($intersectedArray) == count($requiredPosts);
            return $postDataRequired;
        }

        public static function emptyStringsExist(array $arrayToCheckWhetherEmptyValuesExist) : bool {
            /*
                Check whether empty strings exist within in the array provided
            */
            $filteredArrayLength = count(array_filter($arrayToCheckWhetherEmptyValuesExist, "is_string"));
            if($filteredArrayLength != count($arrayToCheckWhetherEmptyValuesExist)) {
                /*
                 * Reject array values where they are integers or other values
                 * because this function only checks if empty strings are
                 *  present in the array
                */
                return false;
            }

            $emptyValuesExist = false;
            foreach($arrayToCheckWhetherEmptyValuesExist as $value) {
                if(mb_strlen($value, "UTF-8") == 0) {
                    $emptyValuesExist = true;
                    break;
                }
            }

            return $emptyValuesExist;
        }

        public static function detectDuplicatesIndexedArray(array $arrayToDetectDuplicatesIn, bool $isCaseInsensitive = true){
            /*
                Detect duplicates inside an indexed array
                Returns false if the array passed is an associative array (string keys)
            */
            if(!array_is_list($arrayToDetectDuplicatesIn)) {
                $duplicatesExist = false;
                return $duplicatesExist;
            }

            if($isCaseInsensitive) {
                $lowercaseArray = self::strArrayToLower($arrayToDetectDuplicatesIn);
            }
            $flippedArray = array_flip($lowercaseArray ?? $arrayToDetectDuplicatesIn);
            $duplicatesExist = count($flippedArray) != count($arrayToDetectDuplicatesIn);
            return $duplicatesExist;
        }

        public static function detectDuplicatesBetweenIndexedArrays(array $firstArray, array $secondArray, bool $isCaseInsensitive = true) : bool {
            if(!array_is_list($firstArray) || !array_is_list($secondArray)) {
                $duplicatesExist = false;
                return $duplicatesExist;
            }
            if($isCaseInsensitive) {
                /*
                    If the boolean for case insensitive is true,
                    compare the arrays in such case that for example:
                    "empty" in the first array would equal to "Empty" in the other array
                */
                $lowerCaseFirstArray = self::strArrayToLower($firstArray);
                $lowerCaseSecondArray = self::strArrayToLower($secondArray);
            }

            $intersectedArray = array_intersect($lowerCaseFirstArray ?? $firstArray,
                $lowerCaseSecondArray ?? $secondArray
            );
            $duplicatesExist = count($intersectedArray) > 0;
            return $duplicatesExist;
        }

        public static function strArrayToLower(array $stringArray): array
        {
            /*
                Convert an array of strings to lower-case
                The array values are first checked to make sure they are strings
                If one value is not a string, return the original array back to the caller

                Can be used with assoc or indexed arrays
            */
            $stringTypeName = "string";
            $variableValuesAreStrings = self::checkArrayValuesType($stringArray, $stringTypeName);

            if($variableValuesAreStrings) {
                $utf8Encoding = "UTF-8";
                // Convert all the values to lowercase in a string array
                $lowercaseArray = array_map(
                    "mb_strtolower",
                    $stringArray,
                    array_fill(0, count($stringArray), $utf8Encoding)
                );
            }
            return $lowercaseArray ?? $stringArray;
        }

        public static function checkArrayValuesType(array $arrayToCheckTypes, string $variableType): bool
        {
            // Check whether values of an array equal a certain type (through $variableType parameter)
            $variableValuesAreValid = true;
            foreach($arrayToCheckTypes as $checkedValue) {
                $valueType = gettype($checkedValue);

                if($valueType != $variableType) {
                    $variableValuesAreValid = false;
                    break;
                }
            }
            return $variableValuesAreValid;
        }

        public static function shouldAddError(bool $dataIsInvalid, string $sessionErrorText) : void{
            if($dataIsInvalid) {
                /*
                    If the data is invalid then there is an error
                */
                $_SESSION["error"][] = $sessionErrorText;
            }
        }

        public static function checkErrorExists(string $redirectLocation) : void {
            /*
             Redirect the user in case there is an error to the redirectLocation variable
            */
            if(isset($_SESSION["error"])) {
                header("Location: " . $redirectLocation);
                exit;
            }
        }

        public static function validateAllMorphTextFields() : array {
            $knownMorphsValidationResults = Morph::validateMorphTextFields(MorphInputClass::KnownMorph->value);
            ValidationHelper::shouldAddError($knownMorphsValidationResults["emptyTextFieldsExist"], "Invalid known morphs");
            var_dump($knownMorphsValidationResults["emptyTextFieldsExist"]);
            ValidationHelper::shouldAddError($knownMorphsValidationResults["duplicateTextFieldsExist"], "Duplicate known morphs");

            $possibleMorphsValidationResults = Morph::validateMorphTextFields(MorphInputClass::PossibleMorph->value);
            ValidationHelper::shouldAddError($possibleMorphsValidationResults["emptyTextFieldsExist"], "Invalid possible morphs");
            ValidationHelper::shouldAddError($possibleMorphsValidationResults["duplicateTextFieldsExist"], "Duplicate possible morphs");

            $testMorphsValidationResults = Morph::validateMorphTextFields(MorphInputClass::TestMorph->value);
            ValidationHelper::shouldAddError($testMorphsValidationResults["emptyTextFieldsExist"], "Invalid tested morphs");
            ValidationHelper::shouldAddError($testMorphsValidationResults["duplicateTextFieldsExist"], "Duplicate tested morphs");


            // Check whether duplicates exist between known and possible morphs because
            // they can't appear in both sections
            $duplicatesExistBetweenKnownPossibleMorphs = Morph::detectDuplicatesBetweenMorphCategories(MorphInputClass::KnownMorph->value, MorphInputClass::PossibleMorph->value);
            ValidationHelper::shouldAddError($duplicatesExistBetweenKnownPossibleMorphs, "Duplicates between known and possible morphs");

            return [
              "knownMorphsValidationResults" => $knownMorphsValidationResults,
              "possibleMorphsValidationResults" => $possibleMorphsValidationResults,
              "testMorphsValidationResults" => $testMorphsValidationResults,
                "duplicatesExistBetweenKnownPossibleMorphs" => $duplicatesExistBetweenKnownPossibleMorphs
            ];
        }
    }