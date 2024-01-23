<?php

namespace MyApp\Models;

use Config\Database;
use PDO;
use PDOException;

class Sex extends Database
{
    private int $sexId = -1;
    private string $sexName = "";

    public function __construct(
        int    $pSexId = -1,
        string $pSexName = ""
    )
    {
        $this->initializeProperties(
            $pSexId,
            $pSexName
        );
    }

    private function initializeProperties(
        int    $pSexId,
        string $pSexName
    ): void
    {
        if ($pSexId < 0) return;
        else if (
            $pSexId > 0
            && strlen($pSexName) > 0
        ) {
            $this->sexId = $pSexId;
            $this->sexName = $pSexName;
        } else if ($pSexId > 0) {
            $this->getSexById($pSexId);
        }
    }

    private function getSexById(int $pSexId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM sex WHERE sex_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pSexId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $this->sexId = $result['sex_id'];
                $this->sexName = $result['sex_name'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt?->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getSexByName(string $pSexName): Sex
    {
        $sex = new Sex();
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM sex WHERE sex_name = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pSexName, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $sex->sexId = $result['sex_id'];
                $sex->sexName = $result['sex_name'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt?->closeCursor();
            $dBConnection = null;
        }

        return $sex;
    }

    public function getSexId(): int
    {
        return $this->sexId;
    }

    public function setSexId(int $sexId): void
    {
        $this->sexId = $sexId;
    }

    public function getSexName(): string
    {
        return $this->sexName;
    }

    public function setSexName(string $sexName): void
    {
        $this->sexName = $sexName;
    }
}