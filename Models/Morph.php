<?php

namespace Models;
include_once 'database.php';
class Morph
{
    private int $morphId = -1;
    private string $morphName = "";
    private bool $isTested = false;
    function __construct(
        $pMorphId = -1,
        $pMorphName = -1,
        $pIsTested = -1,
    ) {
        $this->initializeProperties(
            $pMorphId,
            $pMorphName,
            $pIsTested,
        );
    }

    private function initializeProperties(
        $pMorphId,
        $pMorphName,
        $pIsTested,
    ): void
    {
        if ($pMorphId < 0) return;
        else if (
            $pMorphId > 0
            && $pMorphName > 0
            && $pIsTested > 0
            && strlen($pMorphId) > 0
        ) {
            $this->morphId = $pMorphId;
            $this->morphName = $pMorphName;
            $this->isTested = $pIsTested;
        } else if ($pMorphId > 0) {
            $this->getMorphById($pMorphId);
        }
    }
    private function getMorphById($pMorphId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM morph WHERE morph_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pMorphId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $this->morphId = $pMorphId;
            $this->morphName = $result['morph_name'];
            $this->isTested = $result['is_tested'];
        }
    }
    public static function getMorphByName($pMorphName): ?Morph
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM morph WHERE morph_name = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('s', $pMorphName);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $morph = new Morph();
            $result = $result->fetch_assoc();
            $morph->morphId = $result['morph_id'];
            $morph->morphName = $pMorphName;
            $morph->isTested = $result['is_tested'];
            return $morph;
        }
        return null;
    }
    public static function createMorph($pMorphName, $pIsTested): bool
    {
        $dBConnection = openDatabaseConnection();
        $sql = "INSERT INTO morph (morph_name, is_tested) VALUES (?, ?)";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('si', $pMorphName, $pIsTested);
        $isSuccessful = $stmt->execute();
        $stmt->close();
        $dBConnection->close();
        return $isSuccessful;
    }
    public static function updateMorph($pMorphName, $pIsTested, $pMorphId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "UPDATE morph SET morph_name = ?, is_tested = ? WHERE morph_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('sii', $pMorphName, $pIsTested, $pMorphId);
        $stmt->close();
        $dBConnection->close();
    }
    public static function deleteMorph(int $pMorphId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "DELETE FROM morph WHERE morph_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pMorphId);
        $stmt->execute();
        $stmt->close();
        $dBConnection->close();
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
