<?php
include_once 'database.php';

class Morph
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
            $this->getMorphById($pMorphId);
        }
    }

    private function getMorphById(int $pMorphId): void
    {
        $dBConnection = openDatabaseConnection();

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

    public static function getMorphByName(string $pMorphName): ?Morph
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM morph WHERE morph_name = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pMorphName, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $morph = new Morph();
                $morph->morphId = $result['morph_id'];
                $morph->morphName = $pMorphName;
                $morph->isTested = $result['is_tested'];
                return $morph;
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

    public static function createMorph(string $pMorphName, bool $pIsTested): bool
    {
        $dBConnection = openDatabaseConnection();

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
        $dBConnection = openDatabaseConnection();

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
        $dBConnection = openDatabaseConnection();

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
