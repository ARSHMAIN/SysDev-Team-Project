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
             * If an item is denied, it would mean
             * the intersected array length would be less than the post array's length
             *
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

        public static function emptyStringsExist(array $checkedArray) : bool {
            /*
                Check whether empty strings exist within in the array provided
            */
            $filteredArrayLength = count(array_filter($checkedArray, "is_string"));
            if($filteredArrayLength != count($checkedArray)) {
                /*
                 * Reject array values where they are integers or other values
                 * because this function only checks if empty strings are
                 *  present in the array
                */
                return false;
            }

            $emptyValuesExist = false;
            foreach($checkedArray as $value) {
                if(mb_strlen($value, "UTF-8") == 0) {
                    $emptyValuesExist = true;
                    break;
                }
            }

            return $emptyValuesExist;
        }

        public static function detectDuplicatesIndexedArray(array $arrayToDetectDuplicatesIn, bool $isCaseInsensitive = true): bool
        {
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
            /*
             * Flipped array helps us find the duplicate array
             * because duplicate values are discarded in the array_flip function
            */
            $flippedArray = array_flip($lowercaseArray ?? $arrayToDetectDuplicatesIn);
            $duplicatesExist = count($flippedArray) != count($arrayToDetectDuplicatesIn);
            return $duplicatesExist;
        }

        public static function duplicatesExistBetweenIndexedArrays(array $firstArray, array $secondArray, bool $isCaseInsensitive = true) : bool {
            if(!array_is_list($firstArray) || !array_is_list($secondArray)) {
                return false;
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
                $_SESSION["error"] = array_unique($_SESSION["error"]);
            }
        }

        public static function checkSessionErrorExists(string $redirectLocation) : void {
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

        public static function validateSnakeSexAndOrigin(): array
        {
            // Validate the snake's sex and the origin of the snake

            $sexPostValidationResults = ValidationHelper::validateRequiredSingleFormValue(
                $_POST["sex"],
                "string",
                true,
                "Invalid snake sex"
            );

            $snakeOriginPostIsString = ValidationHelper::checkFormValueType(
                $_POST["snakeOrigin"],
                "string",
                true,
                "Invalid snake origin"
            );

            return [
              "sexPostValidationResults" => $sexPostValidationResults,
              "snakeOriginPostIsString" => $snakeOriginPostIsString
            ];
        }

        public static function checkFormValueType(mixed $postVariable,
                                                  string $variableTypeToCheck = "string",
                                                  bool $addError = true,
                                                  string $sessionErrorText = "",
                                                  ): bool
        {
            // This function checks whether a value is of a certain datatype
            // The available data types in PHP are here: https://www.php.net/manual/en/function.gettype.php
            $variableIsCorrectType = false;
            if(isset($postVariable)) {
                $variableIsCorrectType = gettype($postVariable) == $variableTypeToCheck;
            }

            if($addError && !$variableIsCorrectType) {
                ValidationHelper::shouldAddError(true, $sessionErrorText);
            }
            return $variableIsCorrectType;
        }


        public static function validateRequiredSingleFormValue(
            mixed $postVariable,
            string $variableTypeToCheck = "string",
            bool $addError = true,
            string $sessionErrorText = ""
        ): array
        {
            // Validate a required single form value for its emptiness or its data type (array or string)
            // This checks whether the POST variable matches a certain variable type
            // and whether or not the POST variable sent was empty
            $postValueIsCorrectType = ValidationHelper::checkFormValueType(
                $postVariable,
                $variableTypeToCheck,
                 false
            );

            $postValueIsEmpty = true;
            if($postValueIsCorrectType && ($variableTypeToCheck == "string")) {
                // If the variable type checked is a string, check if the post variable is empty
                $utf8Encoding = "UTF-8";
                $postValueIsEmpty = mb_strlen($postVariable, $utf8Encoding) == 0;

            }

            if($addError && (!$postValueIsCorrectType || $postValueIsEmpty)) {
                ValidationHelper::shouldAddError(true, $sessionErrorText);
            }

            return [
                "postValueIsCorrectType" => $postValueIsCorrectType,
                "postValueIsEmpty" => $postValueIsEmpty
            ];
        }

        public static function validateFirstNameAndLastName(): array
        {
            $firstNameValidationResults = ValidationHelper::validateRequiredSingleFormValue(
                $_POST["firstName"],
                "string",
                true,
                "Invalid first name"
            );

            $lastNameValidationResults = ValidationHelper::validateRequiredSingleFormValue(
              $_POST["lastName"],
              "string",
              true,
              "Invalid last name"
            );

            return [
              "firstNameValidationResults" => $firstNameValidationResults,
              "lastNameValidationResults" => $lastNameValidationResults
            ];
        }

        public static function validateEmailAndPassword(): array
        {
            $emailValidationResults = ValidationHelper::validateRequiredSingleFormValue(
                $_POST["email"],
                "string",
                true,
                "Invalid email"
            );

            $passwordValidationResults = ValidationHelper::validateRequiredSingleFormValue(
              $_POST["password"],
              "string",
              true,
              "Invalid password"
            );


            return [
                "emailValidationResults" => $emailValidationResults,
                "passwordValidationResults" => $passwordValidationResults,
            ];
        }

        public static function validateEditProfileInformation(): array
        {
            $firstNameLastNameValidationResults = ValidationHelper::validateFirstNameAndLastName();

            $phoneNumberValidationResults = ValidationHelper::checkFormValueType(
              $_POST["phoneNumber"],
                "string",
                true,
                "Invalid phone number"
            );

            $companyNameValidationResults = ValidationHelper::checkFormValueType(
              $_POST["companyName"],
              "string",
              true,
              "Invalid company name"
            );

            $streetNumberValidationResults = ValidationHelper::validateRequiredSingleFormValue(
              $_POST["streetNumber"],
                "string",
                true,
                "Invalid street number"
            );

            $streetNameValidationResults = ValidationHelper::validateRequiredSingleFormValue(
              $_POST["streetName"],
                "string",
                true,
                "Invalid street name"
            );

            $cityValidationResults = ValidationHelper::validateRequiredSingleFormValue(
              $_POST["city"],
              "string",
              true,
              "Invalid city"
            );

            $stateOrRegionValidationResults = ValidationHelper::checkFormValueType(
              $_POST["stateOrRegion"],
              "string",
              true,
              "Invalid state/region"
            );

            $postalCodeValidationResults = ValidationHelper::validateRequiredSingleFormValue(
                $_POST["postalCode"],
                "string",
                true,
                "Invalid postal code"
            );

            $countryValidationResults = ValidationHelper::validateRequiredSingleFormValue(
              $_POST["country"],
              "string",
              true,
              "Invalid country"
            );

            return [
                "firstNameLastNameValidationResults" => $firstNameLastNameValidationResults,
                "phoneNumberValidationResults" => $phoneNumberValidationResults,
                "streetNumberValidationResults" => $streetNumberValidationResults,
                "streetNameValidationResults" => $streetNameValidationResults,
                "cityValidationResults" => $cityValidationResults,
                "stateOrRegionValidationResults" => $stateOrRegionValidationResults,
                "postalCodeValidationResults" => $postalCodeValidationResults,
                "countryValidationResults" => $countryValidationResults
            ];
        }
    }