<?php
class Role extends Model
{
    private int $roleId = -1;
    private string $roleName = "";

    public function __construct(
        int $pRoleId = -1,
        string $pRoleName = ""
    ) {
        $this->initializeProperties(
            $pRoleId,
            $pRoleName
        );
    }

    private function initializeProperties(
        int $pRoleId,
        string $pRoleName
    ): void {
        if ($pRoleId < 0) return;
        else if (
            $pRoleId > 0
            && strlen($pRoleName) > 0
        ) {
            $this->roleId = $pRoleId;
            $this->roleName = $pRoleName;
        } else if ($pRoleId > 0) {
            $this->getRoleById($pRoleId);
        }
    }

    private function getRoleById(int $pRoleId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM role WHERE role_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pRoleId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->roleId = $pRoleId;
                $this->roleName = $result['role_name'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getRoleByName(string $pRoleName): Role
    {
        $role = new Role();
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM role WHERE role_name = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pRoleName, PDO::PARAM_STR);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $role->roleId = $result['role_id'];
                $role->roleName = $pRoleName;
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }

        return $role;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }

    public function getRoleName(): string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): void
    {
        $this->roleName = $roleName;
    }
}