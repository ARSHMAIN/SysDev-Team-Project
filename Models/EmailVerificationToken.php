<?php
class EmailVerificationToken extends Model {
    private int $tokenId = -1;
    private int $userId = -1;
    private ?string $resetEmailHash = "";
    private ?string $resetEmailHashExpiresAt = "";
    private ?string $newEmail = "";

    public function __construct(
        int     $pTokenId = -1,
        int     $pUserId = -1,
        ?string $pResetEmailHash = "",
        ?string $pResetEmailHashExpiresAt =  "",
        ?string $pNewEmail = ""
    ) {

        $this->initializeProperties(
            $pTokenId,
            $pUserId,
            $pResetEmailHash,
            $pResetEmailHashExpiresAt,
            $pNewEmail
        );
    }

    private function initializeProperties(
        int  $pTokenId,
        int     $pUserId,
        ?string $pResetEmailHash,
        ?string $pResetEmailHashExpiresAt,
        ?string $pNewEmail
    ): void {
        if ($pTokenId < 0 && $pUserId < 0) return;
        else if (
            $pTokenId > 0
            && $pUserId > 0
            && (mb_strlen($pResetEmailHash, "UTF-8") >= 0 || $pResetEmailHash == null)
            && (mb_strlen($pResetEmailHashExpiresAt, "UTF-8") >= 0 || $pResetEmailHashExpiresAt == null)
            && (mb_strlen($pNewEmail, "UTF-8") >= 0 || $pNewEmail == null)
        ) {
            $this->tokenId = $pTokenId;
            $this->userId = $pUserId;
            $this->resetEmailHash = $pResetEmailHash;
            $this->resetEmailHashExpiresAt = $pResetEmailHashExpiresAt;
            $this->newEmail = $pNewEmail;
        } else if ($pTokenId > 0) {
            $this->getByTokenId($pTokenId);
        }
        else if($pUserId > 0) {
            $this->getByUserId($pUserId);
        }
    }

    // Do not call the two functions below, use the constructor instead with named parameters
    private function getByTokenId(
        int $pTokenId,
    ): void
    {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT * FROM emailverificationtoken WHERE token_id = ?;";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pTokenId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $this->initializeProperties(
                    $result["token_id"],
                    $result["user_id"],
                    $result["reset_email_hash"],
                    $result["reset_email_hash_expires_at"],
                    $result["new_email"]
                );

            }
        }
        catch (PDOException $e) {
            // Handle the exception as per your application's requirements
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
                $emailVerificationToken ?? new EmailVerificationToken();
            return;
        }
    }

    private function getByUserId(
        int $pUserId,
    ): void
    {
        $dBConnection = self::openDatabaseConnection();
        try {
            $sql = "SELECT * FROM emailverificationtoken WHERE user_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $this->initializeProperties(
                    $result["token_id"],
                    $result["user_id"],
                    $result["reset_email_hash"],
                    $result["reset_email_hash_expires_at"],
                    $result["new_email"]
                );
            }

        }
        catch (PDOException $e) {
            // Handle the exception as per your application's requirements
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
                $emailVerificationToken ?? new EmailVerificationToken();
            return;
        }
    }


    public static function createIfNotExists(int    $pUserId,
                                             string $pResetEmailHash,
                                             string $pResetEmailHashExpiresAt,
                                             string $pNewEmail,
                                             bool   $addError,
                                             string $sessionErrorText = "",
    ): array
    {
        try {
            // Creates an emailverificationtoken row if it does not exist already
            // Stores/updates verification link hashes for changing an email for a certain account
            // If it exists, it will get updated
            $dbConnection = self::openDatabaseConnection();

            $sqlQuery = "INSERT INTO emailverificationtoken (user_id, reset_email_hash, reset_email_hash_expires_at, new_email) 
                VALUES (:userId, :resetEmailHash, :resetEmailHashExpiresAt, :newEmail) 
                ON DUPLICATE KEY UPDATE
                reset_email_hash = :resetEmailHashDupKey,
                reset_email_hash_expires_at = :resetEmailHashExpiresAtDupKey,
                new_email = :newEmailDupKey;";
            $pdoStatement = $dbConnection->prepare($sqlQuery);
            
            $pdoStatement->bindValue(":userId", $pUserId);
            $pdoStatement->bindValue(":resetEmailHash", $pResetEmailHash);
            $pdoStatement->bindValue(":resetEmailHashExpiresAt", $pResetEmailHashExpiresAt);
            $pdoStatement->bindValue(":newEmail", $pNewEmail);
            $pdoStatement->bindValue(":resetEmailHashDupKey", $pResetEmailHash);
            $pdoStatement->bindValue(":resetEmailHashExpiresAtDupKey", $pResetEmailHashExpiresAt);
            $pdoStatement->bindValue(":newEmailDupKey", $pNewEmail);

            $isSuccessful = $pdoStatement->execute();

            $emailVerificationToken = new EmailVerificationToken();
            if($isSuccessful && $pdoStatement->rowCount() > 0) {
                // TODO: look at the documentation for the lastInsertId
                $emailVerificationToken->initializeProperties(
                    $dbConnection->lastInsertId(),
                    $pUserId,
                    $pResetEmailHash,
                    $pResetEmailHashExpiresAt,
                    $pNewEmail
                );
            }
            $pdoStatement->closeCursor();

            return [
                "isSuccessful" => $isSuccessful,
                "emailVerificationToken" => $emailVerificationToken
            ];
        }
        catch(PDOException $pdoException) {
            if($addError) {
                ValidationHelper::shouldAddError(true, $sessionErrorText);
            }
        }
        finally {
            $dbConnection = null;
        }
        return [
            "isSuccessful" => $isSuccessful ?? false,
            "emailVerificationToken" => $emailVerificationToken ?? new EmailVerificationToken()
        ];
    }

    public static function getByResetEmailHash(
        string $pResetEmailHash,
        bool $addError,
        string $sessionErrorText = ""
    ): array
    {
        try {
            $dbConnection = self::openDatabaseConnection();
            $sqlQuery = "
                SELECT * FROM emailverificationtoken
                WHERE reset_email_hash = :resetEmailHash;
            ";

            $pdoStatement = $dbConnection->prepare($sqlQuery);

            $pdoStatement->bindValue(":resetEmailHash", $pResetEmailHash);

            $isSuccessful = $pdoStatement->execute();
            $result = $pdoStatement->fetch(PDO::FETCH_ASSOC);

            if($pdoStatement->rowCount() > 0) {

                $emailVerificationToken = new EmailVerificationToken(
                    $result["token_id"],
                    $result["user_id"],
                    $result["reset_email_hash"],
                    $result["reset_email_hash_expires_at"],
                    $result["new_email"]
                );
                return [
                    "emailVerificationToken" => $emailVerificationToken,
                    "isSuccessful" => $isSuccessful
                ];
            }
            $pdoStatement->closeCursor();
        }
        catch(PDOException $pdoException) {
            if($addError) {
                ValidationHelper::shouldAddError(true, $sessionErrorText);
            }
        }
        finally {
            $dbConnection = null;
        }

        return [
            "emailVerificationToken" => $emailVerificationToken ?? new EmailVerificationToken(),
            "isSuccessful" => $isSuccessful ?? false
        ];
    }

    public function getTokenId(): int
    {
        return $this->tokenId;
    }

    public function setTokenId(int $tokenId): void
    {
        $this->tokenId = $tokenId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getResetEmailHash(): ?string
    {
        return $this->resetEmailHash;
    }

    public function setResetEmailHash(?string $resetEmailHash): void
    {
        $this->resetEmailHash = $resetEmailHash;
    }

    public function getResetEmailHashExpiresAt(): ?string
    {
        return $this->resetEmailHashExpiresAt;
    }

    public function setResetEmailHashExpiresAt(?string $resetEmailHashExpiresAt): void
    {
        $this->resetEmailHashExpiresAt = $resetEmailHashExpiresAt;
    }

    public function getNewEmail(): ?string
    {
        return $this->newEmail;
    }

    public function setNewEmail(?string $newEmail): void
    {
        $this->newEmail = $newEmail;
    }

    public static function generateEmailVerificationHash(bool $addError, string $sessionErrorText): string
    {
        try {
            // We generate a random hexadecimal token because we want the hashed token to be unpredictable
            $token = bin2hex(random_bytes(16));


            // We hash the token for security reasons in sha256 algorithm (creates a 64 character wide hashed token)
            return hash("sha256", $token);
        }
        catch(Random\RandomException $randomException) {
            if($addError) {
                ValidationHelper::shouldAddError(true, $sessionErrorText);
            }
        }
        return "";
    }

    public static function generateExpiryDate(int $secondsUntilExpiryDate): string
    {
        // Generate an expiry date
        /*
            We create a date because we need an expiry date for the emailverificationtoken reset_email_hash_expires_at column
            Date format: 2022-01-05 21:55:30
        */
        return date("Y-m-d H:i:s", time() + $secondsUntilExpiryDate);
    }

    public static function updateRowByUserId(
        int      $pUserId,
        ?string  $pResetEmailHash,
        ?string  $pResetEmailHashExpiresAt,
        ?string $pNewEmail,
        bool $addError,
        string $sessionErrorText
    ): bool
    {
        try {
            $dbConnection = self::openDatabaseConnection();

            $sqlQuery = "
                UPDATE emailverificationtoken 
                SET reset_email_hash = :resetEmailHash,
                reset_email_hash_expires_at = :resetEmailHashExpiresAt,
                new_email = :newEmail
                WHERE user_id = :userId;
            ";

            $pdoStatement = $dbConnection->prepare($sqlQuery);
            $pdoStatement->bindValue(":resetEmailHash", $pResetEmailHash);
            $pdoStatement->bindValue(":resetEmailHashExpiresAt", $pResetEmailHashExpiresAt);
            $pdoStatement->bindValue(":newEmail", $pNewEmail);
            $pdoStatement->bindValue(":userId", $pUserId);

            $isSuccessful = $pdoStatement->execute();
            $pdoStatement->closeCursor();

        }
        catch(PDOException $pdoException) {
            if($addError) {
                ValidationHelper::shouldAddError(true, $sessionErrorText);
            }
        }
        finally {
            $dbConnection = null;
            return $isSuccessful ?? false;
        }
    }
}