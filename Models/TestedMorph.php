<?php
include_once 'database.php';

class TestedMorph
{
    private int $testId = -1;
    private int $morphId = -1;
    private string $result = "";
    private string $comment = "";
    private string $resultImagePath = "";

    public function __construct(
        int $pTestId = -1,
        int $pMorphId = -1,
        string $pResult = "",
        string $pComment = "",
        string $pResultImagePath = ""
    ) {
        $this->initializeProperties(
            $pTestId,
            $pMorphId,
            $pResult,
            $pComment,
            $pResultImagePath
        );
    }

    private function initializeProperties(
        int $pTestId,
        int $pMorphId,
        string $pResult,
        string $pComment,
        string $pResultImagePath
    ): void {
        if ($pTestId < 0) return;
        else if (
            $pTestId > 0
            && $pMorphId > 0
            && strlen($pResult) > 0
            && strlen($pComment) > 0
            && strlen($pResultImagePath) > 0
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
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM testedmorph WHERE test_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pTestId, PDO::PARAM_INT);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $testedMorphs = [];
            foreach ($results as $row) {
                $testedMorph = new TestedMorph(
                    $pTestId,
                    $row['morph_id'],
                    $row['result'],
                    $row['comment'],
                    $row['result_image_path']
                );
                $testedMorphs[] = $testedMorph;
            }

            return $testedMorphs;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function create(int $pTestId, array $pMorphIds): bool
    {
        $dBConnection = openDatabaseConnection();

        try {
            // Build the SQL statement
            $sql = "INSERT INTO testedmorph (test_id, morph_id) VALUES ";
            $sql .= implode(',', array_fill(0, count($pMorphIds), "(?, $pTestId)"));

            // Prepare the statement
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters
            foreach ($pMorphIds as $index => $morphId) {
                $stmt->bindParam($index + 1, $morphId, PDO::PARAM_INT);
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


    public static function updateTestedMorph(int $pTestId, int $pMorphId, array $postFields): bool
    {
        $dBConnection = openDatabaseConnection();

        foreach ($postFields as $key => $value) {
            if ($value === '') {
                $postFields[$key] = null;
            }
        }

        try {
            $sql = "UPDATE testedmorph SET result = ?, comment = ?, result_image_path = ? WHERE test_id = ? AND morph_id = ?";
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
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "DELETE FROM testedmorph WHERE test_id = ? AND morph_id = ?";
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