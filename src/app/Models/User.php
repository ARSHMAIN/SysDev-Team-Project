<?php

namespace MyApp\Models;

use Config\Database;
use PDO;
use PDOException;

class User extends Database
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
    )
    {
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
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT * FROM user WHERE user_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
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
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getUserByCredentials(string $pEmail, string $pPassword, string $sessionErrorText): ?User
    {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT * FROM user WHERE email = ? AND password = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pEmail, PDO::PARAM_STR);
            $stmt->bindParam(2, $pPassword, PDO::PARAM_STR);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $isSuccessful = $stmt->rowCount() > 0;

            if ($result) {
                $user = new User();
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
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            ValidationHelper::shouldAddError(true, $sessionErrorText);
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }

        if(!$isSuccessful) {
            ValidationHelper::shouldAddError(true, $sessionErrorText);
        }

        return null;
    }

    public static function getUserByRoleName(string $pRoleName): User
    {
        $user = new User();
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT * FROM user WHERE role_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $roleId = Role::getRoleByName($pRoleName)->getRoleId();
            $stmt->bindParam(1, $roleId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
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
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
        return $user;
    }

    public static function createUserByRoleName(array $postFields, string $sessionErrorText): array
    {
        $dBConnection = self::openDatabaseConnection();
        $isSuccessful = false;
        try {
            foreach ($postFields as $key => $value) {
                if ($value === '') {
                    $postFields[$key] = null;
                }
            }

            $sql = "INSERT INTO user (first_name, last_name, email, password, phone_number, company_name, role_id) VALUES (:firstName, :lastName, :email, MD5(:password), :phoneNumber, :companyName, :roleId)";
            $stmt = $dBConnection->prepare($sql);
            /* If the role id gotten from the post fields is null,
                choose the default user role id for the new user
            */
            $newUserRoleId = $postFields["roleId"] ?? 3;
            $stmt->bindParam(':firstName', $postFields['firstName']);
            $stmt->bindParam(':lastName', $postFields['lastName']);
            $stmt->bindParam(':email', $postFields['email']);
            $stmt->bindParam(':password', $postFields['password']);
            $stmt->bindParam(':phoneNumber', $postFields['phoneNumber']);
            $stmt->bindParam(':companyName', $postFields['companyName']);
            $stmt->bindParam(':roleId', $newUserRoleId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();
            $userId = $dBConnection->lastInsertId();
            return [
                'isSuccessful' => $isSuccessful,
                'newRegisteredUserId' => $userId
            ];
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            ValidationHelper::shouldAddError(!$isSuccessful, $sessionErrorText);
            return [
                'isSuccessful' => false,
                'newRegisteredUserId' => -1
            ];
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function updatePersonalInfo(int $pUserId, array $postFields): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            foreach ($postFields as $key => $value) {
                if ($value === '') {
                    $postFields[$key] = null;
                }
            }

            $sql = "UPDATE user SET first_name = :firstName, last_name = :lastName, password = MD5(:password), phone_number = :phoneNumber, company_name = :companyName, role_id = :roleId WHERE user_id = :userId";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(':firstName', $postFields['firstName']);
            $stmt->bindParam(':lastName', $postFields['lastName']);
            $stmt->bindParam(':password', $postFields['password']);
            $stmt->bindParam(':phoneNumber', $postFields['phoneNumber']);
            $stmt->bindParam(':companyName', $postFields['companyName']);
            $stmt->bindParam(':roleId', $postFields['roleId'], PDO::PARAM_INT);
            $stmt->bindParam(':userId', $pUserId, PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function updateInsensitivePersonalInformation(int $pUserId,
                                                                array $postArray,
                                                                string $sessionErrorText): bool
    {
        $dbConnection = self::openDatabaseConnection();

        $isSuccessful = false;
        try{
            $sqlQuery = "UPDATE user SET first_name = :firstName,
                last_name = :lastName,
                phone_number = :phoneNumber,
                company_name = :companyName
                WHERE user_id = :userId
                ;
            ";

            $pdoStatement = $dbConnection->prepare($sqlQuery);
            $pdoStatement->bindValue(":firstName", $postArray["firstName"]);
            $pdoStatement->bindValue(":lastName", $postArray["lastName"]);
            $pdoStatement->bindValue(":phoneNumber", mb_strlen($postArray["phoneNumber"], "UTF-8") == 0? null : $postArray["phoneNumber"]);
            $pdoStatement->bindValue(":companyName", mb_strlen($postArray["companyName"], "UTF-8") == 0? null : $postArray["companyName"]);
            $pdoStatement->bindValue(":userId", $pUserId);

            $isSuccessful = $pdoStatement->execute();
        }
        catch(PDOException $pdoException) {
            ValidationHelper::shouldAddError(true, $sessionErrorText);
        }
        finally {
            $pdoStatement->closeCursor();
            $dbConnection = null;
        }

        return $isSuccessful;
    }

    public static function deleteUserById(int $pUserId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "DELETE FROM user WHERE user_id = :userId";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(':userId', $pUserId, PDO::PARAM_INT);

            $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getCompanyName(): ?string
    {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): void
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

    public function getLastLogin(): ?string
    {
        return $this->lastLogin;
    }

    public function setLastLogin(?string $lastLogin): void
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