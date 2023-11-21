<?php

namespace Models;

class Sex
{
    private int $sexId = -1;
    private string $sexName = "";

    function __construct(
        $pSexId = -1,
        $pSexName = ""
    ) {
        $this->initializeProperties(
            $pSexId,
            $pSexName
        );
    }

    private function initializeProperties(
        $pSexId,
        $pSexName
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
            $this->getRoleById($pSexId);
        }
    }

    private function getRoleById($pSexId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM sex WHERE sex_id = :sex_id";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pSexId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $this->sexId = $pSexId;
            $this->sexName = $result['sex_name'];
        }
    }
    public static function getRoleByName($pRoleName): Role
    {
        $sex = new Sex();
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM sex WHERE $pRoleName = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pRoleId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $role->roleId = $result['role_id'];
            $role->roleName = $pRoleName;
        }
        return $role;
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