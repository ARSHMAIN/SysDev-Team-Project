<?php

namespace MyApp\Models;

use Config\Database;
use PDO;
use PDOException;

include_once "src/app/Models/SQLHelper.php";

class KnownPossibleMorph extends Database
{
    private int $snakeId = -1;
    private int $morphId = -1;
    private bool $isKnown = false;

    public function __construct(
        int  $pSnakeId = -1,
        int  $pMorphId = -1,
        bool $pIsKnown = false
    )
    {
        $this->initializeProperties(
            $pSnakeId,
            $pMorphId,
            $pIsKnown
        );
    }

    private function initializeProperties(
        int  $pSnakeId,
        int  $pMorphId,
        bool $pIsKnown
    ): void
    {
        if ($pSnakeId < 0) return;
        else if ($pSnakeId > 0 && $pMorphId > 0) {
            $this->snakeId = $pSnakeId;
            $this->morphId = $pMorphId;
            $this->isKnown = $pIsKnown;
        } /*else if ($pSnakeId > 0) {
            $this->getKnownAndPossibleMorphBySnakeId($pSnakeId);
        }*/
    }

    public static function getKnownAndPossibleMorphBySnakeId(int $pSnakeId): ?array
    {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT * FROM known_possible_morph WHERE snake_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $knownPossibleMorphs = [];
                foreach ($results as $row) {
                    $knownPossibleMorph = new KnownPossibleMorph(
                        $row['snake_id'],
                        $row['morph_id'],
                        $row['is_known']
                    );
                    $knownPossibleMorphs[] = $knownPossibleMorph;
                }
                return $knownPossibleMorphs;
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

    public static function getKnownPossibleMorphsBySnakeId(int $pSnakeId, bool $pIsKnown): ?array
    {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT * FROM known_possible_morph WHERE snake_id = ? AND  is_known = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindValue(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->bindValue(2, $pIsKnown, PDO::PARAM_BOOL);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $knownPossibleMorphs = [];
                foreach ($results as $row) {
                    $knownPossibleMorph = new KnownPossibleMorph(
                        $row['snake_id'],
                        $row['morph_id'],
                        $row['is_known']
                    );
                    $knownPossibleMorphs[] = $knownPossibleMorph;
                }
                return $knownPossibleMorphs;
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }

        return null;
    }

    public static function getKnownPossibleMorphsByMorphId(int $pMorphId): ?KnownPossibleMorph
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM known_possible_morph k JOIN morph m on k.morph_id = m.morph_id WHERE k.morph_id = ? AND m.is_tested = TRUE";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pMorphId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $knownPossibleMorph = new KnownPossibleMorph();
                $knownPossibleMorph->snakeId = $result['snake_id'];
                $knownPossibleMorph->morphId = $result['morph_id'];
                $knownPossibleMorph->isKnown = $result['is_known'];
                return $knownPossibleMorph;
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

    public static function create(int $pSnakeId, array $pMorphIds, bool $pIsKnown): bool
    {
        try {
            $dBConnection = self::openDatabaseConnection();
            // Build the SQL statement
            $sql = "INSERT INTO known_possible_morph (snake_id, morph_id, is_known) VALUES ";
            $sql .= implode(',', array_fill(0, count($pMorphIds), '(?, ?, ?)'));

            // Prepare the statement
            $stmt = $dBConnection->prepare($sql);

            // Initialize the parameter index
            $paramIndex = 1;

            // Iterate over morph IDs and bind parameters
            foreach ($pMorphIds as $morphId) {
                $stmt->bindValue($paramIndex++, $pSnakeId, PDO::PARAM_INT);
                $stmt->bindValue($paramIndex++, $morphId, PDO::PARAM_INT);
                $stmt->bindValue($paramIndex++, $pIsKnown, PDO::PARAM_BOOL);
            }

            // Execute the query
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

    public static function createIfNotExists(int $snakeId, array $arrayOfMorphIds, bool $isKnown) {
        try {
            $dbConnection = self::openDatabaseConnection();

            $sqlQuery = "INSERT INTO knownpossiblemorph (snake_id, morph_id, is_known) VALUES ";
            $sqlQuery .= implode(",", array_fill(0, count($arrayOfMorphIds), "(?, ?, ?)"));
            $sqlQuery .= " ON DUPLICATE KEY UPDATE snake_id = snake_id, morph_id = morph_id;";
            $pdoStatement = $dbConnection->prepare($sqlQuery);

            $currentBindValueIndex = 1;
            foreach($arrayOfMorphIds as $morphId) {
                $pdoStatement->bindValue($currentBindValueIndex++, $snakeId);
                $pdoStatement->bindValue($currentBindValueIndex++, $morphId);
                $pdoStatement->bindValue($currentBindValueIndex++, $isKnown);
            }

            $isSuccessful = $pdoStatement->execute();
        }
        catch(PDOException $pdoException) {
            if ($pdoException->getCode() == '23000') {
                // Handle duplicate key error or other specific error
                die("Error: " . $pdoException->getMessage());
            }
        }
        finally {
            $pdoStatement->closeCursor();
            $dbConnection = null;
        }

        return $isSuccessful ?? false;
    }

    public static function deleteAllRemovedKnownPossibleMorphs(int $snakeId,
                                                               string $errorRedirectLocation,
                                                               array $knownMorphIdsInputted,
                                                               array $possibleMorphIdsInputted,
    )
    {
        $deleteRemovedKnownMorphsIsSuccessful = KnownPossibleMorph::deleteRemovedKnownPossibleMorphs(
            $snakeId,
            $knownMorphIdsInputted,
            true
        );
        ValidationHelper::shouldAddError(!$deleteRemovedKnownMorphsIsSuccessful, "An error occurred when deleting the known morphs");
        ValidationHelper::checkSessionErrorExists($errorRedirectLocation);

        $deleteRemovedPossibleMorphsIsSuccessful = KnownPossibleMorph::deleteRemovedKnownPossibleMorphs(
            $snakeId,
            $possibleMorphIdsInputted,
            false
        );
        ValidationHelper::shouldAddError(!$deleteRemovedPossibleMorphsIsSuccessful, "An error occurred when deleting the possible morphs");
        ValidationHelper::checkSessionErrorExists($errorRedirectLocation);
    }


    public static function deleteRemovedKnownPossibleMorphs(int $snakeId, array $morphIdsToKeep, bool $isKnown)
    {
        /*
            Delete the testedmorph rows that were removed by the customer on the create/update test form
            The bool isKnown represents whether the function should delete known or possible morphs
        */

        $isSuccessful = false;

        if(count($morphIdsToKeep) <= 0) {
            // Not successful
            return false;
        }

        try {
            $dbConnection = self::openDatabaseConnection();
            $sqlQuery = "DELETE FROM known_possible_morph
                    WHERE snake_id = ? AND 
            ";

            if(count($morphIdsToKeep) > 0) {
                $sqlQuery = SQLHelper::concatenateConditions($morphIdsToKeep, $sqlQuery, "morph_id != ?");
                $sqlQuery .= " AND ";
            }

            $sqlQuery .= "is_known = ?;";
            $pdoStatement = $dbConnection->prepare($sqlQuery);
            $currentBindValueIndex = 1;
            /*
                Bind value for knownpossiblemorph.snake_id = ? in the query
            */
            $pdoStatement->bindValue($currentBindValueIndex++, $snakeId);

            if(count($morphIdsToKeep) > 0) {
                $bindValueResult = SQLHelper::bindValues($pdoStatement, $morphIdsToKeep, $currentBindValueIndex);
                $pdoStatement = $bindValueResult["pdoStatement"];
                $currentBindValueIndex = $bindValueResult["currentBindValue"];
            }

            /*
                Bind value for knownpossiblemorph.is_known = ? in the query
            */
            $pdoStatement->bindValue($currentBindValueIndex++, $isKnown);


            $isSuccessful = $pdoStatement->execute();
        } catch (PDOException $pdoException) {
            if ($pdoException->getCode() == '23000') {
                // Handle duplicate key error or other specific error
                die("Error: " . $pdoException->getMessage());
            }
        } finally {
            $pdoStatement->closeCursor();
            $dbConnection = null;
            return $isSuccessful;
        }
    }


    public static function updateKnownPossibleMorph(int $pSnakeId, int $pMorphId, bool $pIsKnown): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "UPDATE known_possible_morph SET morph_id = ?, is_known = ? WHERE snake_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pMorphId, PDO::PARAM_INT);
            $stmt->bindParam(2, $pIsKnown, PDO::PARAM_BOOL);
            $stmt->bindParam(3, $pSnakeId, PDO::PARAM_INT);
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

    public static function deleteKnownPossibleMorph(int $pSnakeId, int $pMorphId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "DELETE FROM known_possible_morph WHERE snake_id = ? AND morph_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->bindParam(2, $pMorphId, PDO::PARAM_INT);
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

    public function getSnakeId(): int
    {
        return $this->snakeId;
    }

    public function setSnakeId(int $snakeId): void
    {
        $this->snakeId = $snakeId;
    }

    public function getMorphId(): int
    {
        return $this->morphId;
    }

    public function setMorphId(int $morphId): void
    {
        $this->morphId = $morphId;
    }

    public function isKnown(): bool
    {
        return $this->isKnown;
    }

    public function setIsKnown(bool $isKnown): void
    {
        $this->isKnown = $isKnown;
    }
}