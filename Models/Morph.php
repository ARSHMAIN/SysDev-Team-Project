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

enum MorphInputClass : string {
    /* Enumeration of all class names for input text fields in the create/update
        test section
    */
    case KnownMorph = "knownMorph";
    case PossibleMorph = "possibleMorph";
    case TestMorph = "testMorph";
}

class Morph extends Model
{
    private int $morphId = -1;
    private string $morphName = "";
    private bool $isTested = false;

    public function __construct(
        int $pMorphId = -1,
        string $pMorphName = "",
        bool $pIsTested = false
    ) {
        $this->initializeProperties(
            $pMorphId,
            $pMorphName,
            $pIsTested
        );
    }

    private function initializeProperties(
        int $pMorphId,
        string $pMorphName,
        bool $pIsTested
    ): void {
        if ($pMorphId < 0) return;
        else if (
            $pMorphId > 0
            && strlen($pMorphName) > 0
        ) {
            $this->morphId = $pMorphId;
            $this->morphName = $pMorphName;
            $this->isTested = $pIsTested;
        } else if ($pMorphId > 0) {
            $this->getById($pMorphId);
        }
    }

    private function getById(int $pMorphId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM morph WHERE morph_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pMorphId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->morphId = $pMorphId;
                $this->morphName = $result['morph_name'];
                $this->isTested = $result['is_tested'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getByName(string $pMorphName): ?Morph
    {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT * FROM morph WHERE morph_name = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pMorphName, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $morph = new Morph();
                $morph->morphId = $result['morph_id'];
                $morph->morphName =$result['morph_name'];
                $morph->isTested = $result['is_tested'];
                return $morph;
            }
            return null;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }
    public static function getByIsTested(bool $pIsTested): ?array
    {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT * FROM morph WHERE is_tested = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pIsTested, PDO::PARAM_BOOL);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $testedMorphs = [];
                foreach ($results as $row) {
                    $morph = new Morph();
                    $morph->morphId = $row['morph_id'];
                    $morph->morphName =$row['morph_name'];
                    $morph->isTested = $row['is_tested'];
                    $testedMorphs[] = $morph;
                }
                return $testedMorphs;
            }
            return null;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }
    public static function getByIsTestedAndName(bool $pIsTested, array $pMorphNames): array
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            // Build the SQL statement
            $sql = "SELECT * FROM morph WHERE is_tested = ? AND morph_name IN (" . implode(',', array_fill(0, count($pMorphNames), '?')) . ")";
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters
            $stmt->bindValue(1, $pIsTested, PDO::PARAM_BOOL);

            // Bind morph names
            foreach ($pMorphNames as $index => $morphName) {
                $stmt->bindValue(2 + $index, $morphName, PDO::PARAM_STR);
            }

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $morphs = [];
            foreach ($results as $result) {
                $morph = new Morph();
                $morph->morphId = $result['morph_id'];
                $morph->morphName = $result['morph_name'];
                $morph->isTested = $result['is_tested'];
                $morphs[] = $morph;
            }

            return $morphs;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function createMorph(string $pMorphName, bool $pIsTested): bool
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "INSERT INTO morph (morph_name, is_tested) VALUES (?, ?)";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pMorphName, PDO::PARAM_STR);
            $stmt->bindParam(2, $pIsTested, PDO::PARAM_BOOL);
            $isSuccessful = $stmt->execute();
        } catch (PDOException $e) {
            // Handle specific error conditions
            if ($e->getCode() == '23000') {
                // Handle duplicate key error or other specific error
                die("Error: " . $e->getMessage());
            }
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }

        return $isSuccessful ?? false;
    }

    public static function updateMorph(string $pMorphName, bool $pIsTested, int $pMorphId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "UPDATE morph SET morph_name = ?, is_tested = ? WHERE morph_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pMorphName, PDO::PARAM_STR);
            $stmt->bindParam(2, $pIsTested, PDO::PARAM_BOOL);
            $stmt->bindParam(3, $pMorphId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle specific error conditions
            if ($e->getCode() == '23000') {
                // Handle duplicate key error or other specific error
                die("Error: " . $e->getMessage());
            }
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function deleteMorph(int $pMorphId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "DELETE FROM morph WHERE morph_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pMorphId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle specific error conditions
            if ($e->getCode() == '23000') {
                // Handle foreign key constraint violation or other specific error
                die("Error: " . $e->getMessage());
            }
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getNewMorphs(int $snakeId, array $newMorphs, string $morphType, bool $isKnown) {
        $oldMorphs = KnownPossibleMorph::getKnownPossibleMorphsBySnakeId($snakeId, $isKnown);

        if ($oldMorphs) {
            $oldMorphsNames = [];
            foreach ($oldMorphs as $oldMorph) {
                $oldMorphsNames[] = (new Morph($oldMorph->getMorphId()))->getMorphName();
            }

            foreach ($newMorphs as $newMorph) {
                /*
                    Check if the new morphs typed by the customer also include the old ones
                    If the array with the old morphs is not empty after doing this loop
                    it means that some old morphs were deleted on the client side so return an error
                    (??? not sure if this correct)
                */
                if (!empty($oldMorphsNames && in_array($newMorph, $oldMorphsNames, true))) {
                    $oldMorphIndex = array_search($newMorph, $oldMorphsNames);
                    $newMorphIndex = array_search($newMorph, $newMorphs);
                    unset($oldMorphsNames[$oldMorphIndex]);
                    unset($newMorphs[$newMorphIndex]);
                    $oldMorphsNames = array_values($oldMorphsNames);
                    $newMorphs = array_values($newMorphs);
                }

            }
        }
        /*
            If the array of new morphs is not empty, and the array of old morphs is empty,
            it means that the morphs typed by the customer are the old ones + the new ones
        */
        return empty($newMorphs) ? [] : $newMorphs;
    }


    public static function getMorphIds(array $morphs): array {
        /*
                Get morph IDs from an array of morph names (gotten from POST request)
            */
        $morphIds = [];
        foreach ($morphs as $morph) {
            $morphObj = Morph::getByName($morph);
            $morphIds[] = $morphObj->getMorphId();
        }
        return $morphIds;
    }
    public static function getMorphNames(array $morphs): array
    {
        $morphNames = [];
        foreach ($morphs as $morph) {
            $morphObj = new Morph($morph->getMorphId());
            $morphNames[] = $morphObj->getMorphName();
        }
        return $morphNames;
    }

    public static function getSnakeTestPosts(array $postArray)
    {
        //    $i = 1;
        $array = [];

        foreach($postArray as $morphInput) {
            $array[] = $morphInput;
        }
//    while (true) {
//        $key = $post . $i;
//        if (isset($_POST[$key])) {
//            $array[] = $_POST[$key];
//        } else {
//            break;
//        }
//        $i++;
//    }
        return $array;
    }

    public static function checkMorphsExist(array $morphsToCheck, string $errorMessage): array
    {
        $newMorphs = [];
        foreach ($morphsToCheck as $key => $morph) {
            $morphObj = Morph::getByName($morph);
            if ($morphObj) {
                $newMorphs[] = $morph;
            }
            else {
                /*
                    If there was no morph found matching the current iterated morph in the database,
                    add an error to the session error array
                */
                $_SESSION['error'][] = ($key + 1) . $errorMessage;
            }
        }
        return $newMorphs;
    }

    public function getMorphId(): int
    {
        return $this->morphId;
    }

    public function setMorphId(int $morphId): void
    {
        $this->morphId = $morphId;
    }

    public function getMorphName(): string
    {
        return $this->morphName;
    }

    public function setMorphName(string $morphName): void
    {
        $this->morphName = $morphName;
    }

    public function isTested(): bool
    {
        return $this->isTested;
    }

    public function setIsTested(bool $isTested): void
    {
        $this->isTested = $isTested;
    }
}
