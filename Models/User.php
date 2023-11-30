<?php
include_once 'database.php';
class User
{
    private int $userId = -1;
    private string $firstName = "";
    private string $lastName = "";
    private string $email = "";
    private string $password = "";
    private ?string $phoneNumber = null;
    private ?string $companyName = null;
    private string $registeredDate = "";
    private ?string $lastLogin = null;
    private int $roleId = -1;

    function __construct(
        $pUserId = -1,
        $pFirstName = "",
        $pLastName = "",
        $pEmail = "",
        $pPassword = "",
        $pPhoneNumber = null,
        $pCompanyName = null,
        $pRegisteredDate = "",
        $pLastLogin = null,
        $pRoleId = -1
    ) {
        $this->initializeProperties(
            $pUserId,
            $pFirstName,
            $pLastName,
            $pEmail,
            $pPassword,
            $pPhoneNumber,
            $pCompanyName,
            $pRegisteredDate,
            $pLastLogin,
            $pRoleId
        );
    }

    private function initializeProperties(
        $pUserId,
        $pFirstName,
        $pLastName,
        $pEmail,
        $pPassword,
        $pPhoneNumber,
        $pCompanyName,
        $pRegisteredDate,
        $pLastLogin,
        $pRoleId
    ): void
    {
        if ($pUserId < 0) return;
        else if (
            $pUserId > 0
            && strlen($pFirstName) > 0
            && strlen($pLastName) > 0
            && strlen($pEmail) > 0
            && strlen($pPassword) > 0
            && strlen($pPhoneNumber) > 0
            && strlen($pCompanyName) > 0
            && strlen($pRegisteredDate) > 0
            && strlen($pLastLogin) > 0
            && $pRoleId > 0
        ) {
            $this->userId = $pUserId;
            $this->firstName = $pFirstName;
            $this->lastName = $pLastName;
            $this->email = $pEmail;
            $this->password = $pPassword;
            $this->phoneNumber = $pPhoneNumber;
            $this->companyName = $pCompanyName;
            $this->registeredDate = $pRegisteredDate;
            $this->lastLogin = $pLastLogin;
            $this->roleId = $pRoleId;
        } else if ($pUserId > 0) {
            $this->getUserById($pUserId);
        }
    }
    private function getUserById(int $pUserId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM user WHERE user_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pUserId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $this->userId = $pUserId;
            $this->firstName = $result['first_name'];
            $this->lastName = $result['last_name'];
            $this->email = $result['email'];
            $this->password = $result['password'];
            $this->phoneNumber = $result['phone_number'];
            $this->companyName = $result['company_name'];
            $this->registeredDate = $result['registration_date'];
            $this->lastLogin = $result['last_login'];
            $this->roleId = $result['role_id'];
        }
    }
    public static function getUserByCredentials(string $pEmail, string $pPassword): ?User
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM user WHERE email = ? AND password = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('ss', $pEmail, $pPassword);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user = new User();
            $result = $result->fetch_assoc();
            $user->userId = $result['user_id'];
            $user->firstName = $result['first_name'];
            $user->lastName = $result['last_name'];
            $user->email = $pEmail;
            $user->password = $pPassword;
            $user->phoneNumber = $result['phone_number'];
            $user->companyName = $result['company_name'];
            $user->registeredDate = $result['registration_date'];
            $user->lastLogin = $result['last_login'];
            $user->roleId = $result['role_id'];
            return $user;
        }
        return null;
    }
    public static function getUserByRoleName(string $pRoleName): User
    {
        $user = new User();
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM user WHERE role_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $roleId = Role::getRoleByName($pRoleName)->getRoleId();
        $stmt->bind_param('s', $roleId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $user->userId = $result['user_id'];
            $user->firstName = $result['first_name'];
            $user->lastName = $result['last_name'];
            $user->email = $result['email'];
            $user->password = $result['password'];
            $user->phoneNumber = $result['phone_number'];
            $user->companyName = $result['company_name'];
            $user->registeredDate = $result['registration_date'];
            $user->lastLogin = $result['last_login'];
            $user->roleId = $result['role_id'];
        }
        return $user;
    }
    public static function createUserByRoleName(array $postFields): array
    {
        $dBConnection = openDatabaseConnection();

        foreach ($postFields as $key => $value) {
            if ($value === '') {
                $postFields[$key] = null;
            }
        }

        $sql = "INSERT INTO user (first_name, last_name, email, password, phone_number, company_name, role_id) VALUES (?, ?, ?, md5(?), ?, ?, ?)";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('sssssssi', $postFields['firstName'], $postFields['lastName'], $postFields['email'], $postFields['password'], $postFields['phoneNumber'], $postFields['companyName'], $postFields['roleId']);
        $isSuccessful = $stmt->execute();
        $userId = $dBConnection->insert_id;
        $stmt->close();
        $dBConnection->close();
        return [
            'isSuccessful' => $isSuccessful,
            'newRegisteredUserId' => $userId
        ];
    }
    public static function updatePersonalInfo(int $pUserId, array $postFields): void
    {
        $dBConnection = openDatabaseConnection();

        foreach ($postFields as $key => $value) {
            if ($value === '') {
                $postFields[$key] = null;
            }
        }

        $sql = "UPDATE user SET first_name = ?, last_name = ?, password = ?, phone_number = ?, company_name = ?, role_id = ? WHERE user_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('sssssii', $postFields['firstName'], $postFields['lastName'], $postFields['password'], $postFields['phoneNumber'], $postFields['companyName'], $postFields['roleId'], $pUserId);
        $stmt->execute();
        $stmt->close();
        $dBConnection->close();
    }
    public static function deleteUserById(int $pUserId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "DELETE FROM user WHERE user_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pUserId);
        $stmt->execute();
        $stmt->close();
        $dBConnection->close();
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getCompanyName(): string
    {
        return $this->companyName;
    }

    public function setCompanyName(string $companyName): void
    {
        $this->companyName = $companyName;
    }

    public function getRegisteredDate(): string
    {
        return $this->registeredDate;
    }

    public function setRegisteredDate(string $registeredDate): void
    {
        $this->registeredDate = $registeredDate;
    }

    public function getLastLogin(): string
    {
        return $this->lastLogin;
    }

    public function setLastLogin(string $lastLogin): void
    {
        $this->lastLogin = $lastLogin;
    }

    public function getRoleId(): int
    {
        return $this->roleId;
    }

    public function setRoleId(int $roleId): void
    {
        $this->roleId = $roleId;
    }

}