<?php

namespace MyApp\Models;

use Config\Database;
use PDO;
use PDOException;

include_once "SQLHelper.php";

class TestedMorph extends Database
{
    private int $testId = -1;
    private int $morphId = -1;
    private ?string $result = null;
    private ?string $comment = null;
    private ?string $resultImagePath = null;

    public function __construct(
        int     $pTestId = -1,
        int     $pMorphId = -1,
        ?string $pResult = null,
        ?string $pComment = null,
        ?string $pResultImagePath = null
    )
    {
        $this->initializeProperties(
            $pTestId,
            $pMorphId,
            $pResult,
            $pComment,
            $pResultImagePath
        );
    }

    private function initializeProperties(
        int     $pTestId,
        int     $pMorphId,
        ?string $pResult,
        ?string $pComment,
        ?string $pResultImagePath
    ): void
    {
        if ($pTestId < 0) return;
        else if (
            $pTestId > 0
            && $pMorphId > 0
        ) {
            $this->testId = $pTestId;
            $this->morphId = $pMorphId;
            $this->result = $pResult;
            $this->comment = $pComment;
            $this->resultImagePath = $pResultImagePath;
        }
    }

    public static function getAllTestedMorphById(int $pTestId): ?array
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM tested_morph WHERE test_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pTestId, PDO::PARAM_INT);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {

                $testedMorphs = [];
                foreach ($results as $row) {
                    $testedMorph = new TestedMorph(
                        $row['test_id'],
                        $row['morph_id'],
                        $row['result'],
                        $row['comment'],
                        $row['result_image_path']
                    );
                    $testedMorphs[] = $testedMorph;
                }
                return $testedMorphs;
            }
            return null;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function create(int $pTestId, array $pMorphIds): bool
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            // Build the SQL statement
            $sql = "INSERT INTO tested_morph (test_id, morph_id) VALUES ";
            $sql .= implode(',', array_fill(0, count($pMorphIds), "($pTestId, ?)"));

            // Prepare the statement
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters
            foreach ($pMorphIds as $index => $morphId) {
                $stmt->bindValue($index + 1, $morphId, PDO::PARAM_INT);
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

    public static function deleteRemovedTestedMorphs(int $testId, array $morphIdsToKeep)
    {
        /*
            Delete the testedmorph rows that were removed by the customer on the create/update test form
        */
        $isSuccessful = false;
        try {
            $dbConnection = self::openDatabaseConnection();
            $sqlQuery = "
                DELETE FROM tested_morph
                    WHERE test_id = ? AND
            ";

            $sqlQuery = SQLHelper::concatenateConditions($morphIdsToKeep, $sqlQuery, "morph_id != ?");
            $pdoStatement = $dbConnection->prepare($sqlQuery);

            $currentBindValueIndex = 1;
            $pdoStatement->bindValue($currentBindValueIndex++, $testId);
            $bindValueResult = SQLHelper::bindValues($pdoStatement, $morphIdsToKeep, $currentBindValueIndex);

            $pdoStatement = $bindValueResult["pdoStatement"];

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

    public static function createTestedMorphsIfNotExists(int $pTestId, array $pMorphIds): bool
    {
        $isSuccessful = false;
        try {
            $dbConnection = self::openDatabaseConnection();
            $sqlQuery = "INSERT INTO tested_morph (test_id, morph_id) VALUES ";
            $sqlQuery .= implode(',', array_fill(0, count($pMorphIds), "($pTestId, ?)"));
            $sqlQuery .= " ON DUPLICATE KEY UPDATE testedmorph.test_id = testedmorph.test_id, testedmorph.morph_id = testedmorph.morph_id;
            ";

            $pdoStatement = $dbConnection->prepare($sqlQuery);

            /*
                The current index that allows to bind the next value using PDOStatement::bindValue
            */
            $currentBindValueIndex = 1;
            /*
                Bind the values for the values to insert (morph ids)
            */
            $bindInsertValuesResult = SQLHelper::bindValues($pdoStatement, $pMorphIds, $currentBindValueIndex, PDO::PARAM_INT);
            $pdoStatement = $bindInsertValuesResult["pdoStatement"];


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


    public static function updateTestedMorph(int $pTestId, int $pMorphId, array $postFields): bool
    {
        $dBConnection = self::openDatabaseConnection();

        foreach ($postFields as $key => $value) {
            if ($value === '') {
                $postFields[$key] = null;
            }
        }

        try {
            $sql = "UPDATE tested_morph SET result = ?, comment = ?, result_image_path = ? WHERE test_id = ? AND morph_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $postFields['result'], PDO::PARAM_STR);
            $stmt->bindParam(2, $postFields['comment'], PDO::PARAM_STR);
            $stmt->bindParam(3, $postFields['resultImagePath'], PDO::PARAM_STR);
            $stmt->bindParam(4, $pTestId, PDO::PARAM_INT);
            $stmt->bindParam(5, $pMorphId, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function deleteTestedMorph(int $pTestId, int $pMorphId): bool
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "DELETE FROM tested_morph WHERE test_id = ? AND morph_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pTestId, PDO::PARAM_INT);
            $stmt->bindParam(2, $pMorphId, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public function getTestId(): int
    {
        return $this->testId;
    }

    public function setTestId(int $testId): void
    {
        $this->testId = $testId;
    }

    public function getMorphId(): int
    {
        return $this->morphId;
    }

    public function setMorphId(int $morphId): void
    {
        $this->morphId = $morphId;
    }

    public function getResult(): string
    {
        return $this->result;
    }

    public function setResult(string $result): void
    {
        $this->result = $result;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getResultImagePath(): string
    {
        return $this->resultImagePath;
    }

    public function setResultImagePath(string $resultImagePath): void
    {
        $this->resultImagePath = $resultImagePath;
    }
}