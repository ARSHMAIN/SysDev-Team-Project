<?php
include_once 'database.php';

class KnownPossibleMorph
{
    private int $snakeId = -1;
    private int $morphId = -1;
    private bool $isKnown = false;

    public function __construct(
        int $pSnakeId = -1,
        int $pMorphId = -1,
        bool $pIsKnown = false
    ) {
        $this->initializeProperties(
            $pSnakeId,
            $pMorphId,
            $pIsKnown
        );
    }

    private function initializeProperties(
        int $pSnakeId,
        int $pMorphId,
        bool $pIsKnown
    ): void {
        if ($pSnakeId < 0) return;
        else if ($pSnakeId > 0 && $pMorphId > 0) {
            $this->snakeId = $pSnakeId;
            $this->morphId = $pMorphId;
            $this->isKnown = $pIsKnown;
        } else if ($pSnakeId > 0) {
            $this->getKnownAndPossibleMorphBySnakeId($pSnakeId);
        }
    }

    private function getKnownAndPossibleMorphBySnakeId(int $pSnakeId): void
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM knownpossiblemorph WHERE snake_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->snakeId = $pSnakeId;
                $this->morphId = $result['morph_id'];
                $this->isKnown = $result['is_known'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getKnownOrPossibleMorphsBySnakeId(int $pSnakeId, bool $pIsKnown): KnownPossibleMorph
    {
        $knownPossibleMorph = new KnownPossibleMorph();
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM knownpossiblemorph WHERE snake_id = ? AND is_known = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->bindParam(2, $pIsKnown, PDO::PARAM_BOOL);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $knownPossibleMorph->snakeId = $pSnakeId;
                $knownPossibleMorph->morphId = $result['morph_id'];
                $knownPossibleMorph->isKnown = $pIsKnown;
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }

        return $knownPossibleMorph;
    }

    public static function create(int $pSnakeId, array $pMorphIds, bool $pIsKnown): bool
    {
        $dBConnection = openDatabaseConnection();

        try {
            // Build the SQL statement
            $sql = "INSERT INTO knownpossiblemorph (snake_id, morph_id, is_known) VALUES ";
            $sql .= implode(',', array_fill(0, count($pMorphIds), '(?, ?, ?)'));

            // Prepare the statement
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters
            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->bindParam(3, $pIsKnown, PDO::PARAM_BOOL);

            // Iterate over morph IDs and bind them
            foreach ($pMorphIds as $index => $morphId) {
                $stmt->bindParam(2 + $index * 3, $morphId, PDO::PARAM_INT);
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


    public static function updateKnownPossibleMorph(int $pSnakeId, int $pMorphId, bool $pIsKnown): void
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "UPDATE knownpossiblemorph SET morph_id = ?, is_known = ? WHERE snake_id = ?";
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
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "DELETE FROM knownpossiblemorph WHERE snake_id = ? AND morph_id = ?";
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