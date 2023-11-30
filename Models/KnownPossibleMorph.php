<?php


include_once 'database.php';

class KnownPossibleMorph
{
    private int $snakeId = -1;
    private int $morphId = -1;
    private bool $isKnown = false;
    function __construct(
        $pSnakeId = -1,
        $pMorphId = -1,
        $pIsKnown = false
    ) {
        $this->initializeProperties(
            $pSnakeId,
            $pMorphId,
            $pIsKnown
        );
    }

    private function initializeProperties(
        $pSnakeId,
        $pMorphId,
        $pIsKnown
    ): void
    {
        if ($pSnakeId < 0) return;
        else if (
            $pSnakeId > 0
            && strlen($pSnakeId) > 0
        ) {
            $this->snakeId = $pSnakeId;
            $this->morphId = $pMorphId;
            $this->isKnown = $pIsKnown;
        } else if ($pSnakeId > 0) {
            $this->getKnownAndPossibleMorphBySnakeId($pSnakeId);
        }
    }
    private function getKnownAndPossibleMorphBySnakeId($pSnakeId)
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM knownpossiblemorph WHERE snake_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pSnakeId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $this->snakeId = $pSnakeId;
            $this->morphId = $result['morph_id'];
            $this->isKnown = $result['is_known'];
        }
    }
    public static function getKnownOrPossibleMorphsBySnakeId($pSnakeId, $pIsKnown): KnownPossibleMorph
    {
        $knownPossibleMorph = new KnownPossibleMorph();
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM knownpossiblemorph WHERE snake_id = ? AND is_known = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('ii', $pSnakeId, $pIsKnown);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $knownPossibleMorph->snakeId = $pSnakeId;
            $knownPossibleMorph->morphId = $result['morph_id'];
            $knownPossibleMorph->isKnown = $pIsKnown;
        }
        return $knownPossibleMorph;
    }
    public static function createKnownPossibleMorph(int $pSnakeId, int $pMorphId, bool $pIsKnown): bool
    {
        $dBConnection = openDatabaseConnection();
        $sql = "INSERT INTO knownpossiblemorph (snake_id, morph_id, is_known) VALUES (?, ?, ?)";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('iii', $pSnakeId, $pMorphId, $pIsKnown);
        $isSuccessful = $stmt->execute();
        $stmt->close();
        $dBConnection->close();
        return $isSuccessful;
    }
    public static function updateKnownPossibleMorph(int $pSnakeId, int $pMorphId, bool $pIsKnown): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "UPDATE knownpossiblemorph SET morph_id = ?, is_known = ? WHERE snake_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('iii',$pMorphId, $pIsKnown, $pSnakeId);
        $stmt->execute();
        $stmt->close();
        $dBConnection->close();
    }
    public static function deleteKnownPossibleMorph(int $pMorphId, bool $pIsKnown): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "DELETE FROM knownpossiblemorph WHERE snake_id = ? AND morph_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('ii',$pSnakeId, $pMorphId);
        $stmt->execute();
        $stmt->close();
        $dBConnection->close();
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