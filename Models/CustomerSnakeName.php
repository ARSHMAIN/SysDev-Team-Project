<?php
include_once 'database.php';

class CustomerSnakeName
{
    private string $customerSnakeId = '';
    private int $userId = -1;
    private int $snakeId = -1;

    public function __construct(
        string $pCustomerSnakeId = "",
        int $pUserId = -1,
        int $pSnakeId = -1
    ) {
        $this->initializeProperties(
            $pCustomerSnakeId,
            $pUserId,
            $pSnakeId
        );
    }

    private function initializeProperties(
        string $pCustomerSnakeId,
        int $pUserId,
        int $pSnakeId
    ): void {
        if ($pSnakeId < 0) return;
        else if (
            strlen($pCustomerSnakeId) > 0
            && $pUserId > 0
            && $pSnakeId > 0
        ) {
            $this->customerSnakeId = $pCustomerSnakeId;
            $this->userId = $pUserId;
            $this->snakeId = $pSnakeId;
        } else if ($pSnakeId > 0) {
            $this->getBySnakeId($pSnakeId);
        }
    }

    private function getBySnakeId(int $pSnakeId): void
    {
        $dBConnection = openDatabaseConnection();
        try {
            $sql = "SELECT * FROM customersnakename WHERE snake_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->customerSnakeId = $result['customer_snake_id'];
                $this->userId = $result['user_id'];
                $this->snakeId = $result['snake_id'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getByUserId(int $pUserId): ?array
    {
        $dBConnection = openDatabaseConnection();
        try {
            $sql = "SELECT * FROM customersnakename WHERE user_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);
            $stmt->execute();

            $customerSnakeNames = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $customerSnakeName = new CustomerSnakeName(
                    $row['customer_snake_id'],
                    $row['user_id'],
                    $row['snake_id']
                );
                $customerSnakeNames[] = $customerSnakeName;
            }

            return $customerSnakeNames;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getByUserIdAndCustomerSnakeName(string $pCustomerSnakeId, int $pUserId): ?CustomerSnakeName
    {
        $dBConnection = openDatabaseConnection();
        try {
            $sql = "SELECT * FROM customersnakename WHERE customer_snake_id = ? AND user_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pCustomerSnakeId, PDO::PARAM_STR);
            $stmt->bindParam(2, $pUserId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $customerSnakeName = new CustomerSnakeName();
                $customerSnakeName->customerSnakeId = $result['customer_snake_id'];
                $customerSnakeName->userId = $result['user_id'];
                $customerSnakeName->snakeId = $result['snake_id'];
                return $customerSnakeName;
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

    public static function create(string $pCustomerSnakeId, int $pUserId, int $pSnakeId): array
    {
        $stmt = null; // Initialize $stmt outside the try block

        try {
            $dBConnection = openDatabaseConnection();
            $sql = "INSERT INTO customersnakename (customer_snake_id, user_id, snake_id) VALUES (?, ?, ?)";
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters after checking for empty strings
            $stmt->bindValue(1, $pCustomerSnakeId);
            $stmt->bindValue(2, $pUserId, PDO::PARAM_INT);
            $stmt->bindValue(3, $pSnakeId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();
            $customerSnakeId = $dBConnection->lastInsertId();

            return [
                'isSuccessful' => $isSuccessful,
                'newCustomerSnakeId' => $customerSnakeId
            ];
        } catch (PDOException $e) {
            // Handle specific error conditions
            if ($e->getCode() == '23000') {
                // Check the error message for more detailed information
                if (str_contains($e->getMessage(), 'NOT NULL')) {
                    // Handle NOT NULL constraint violation
                    return [
                        'isSuccessful' => false,
                        'error' => 'NOT NULL constraint violation. Please provide values for all required fields.',
                    ];
                } elseif (str_contains($e->getMessage(), 'Duplicate entry')) {
                    // Handle duplicate key error
                    return [
                        'isSuccessful' => false,
                        'error' => 'Duplicate entry. The combination of customer_snake_id, user_id, and snake_id must be unique.',
                    ];
                } else {
                    // Handle other errors
                    die("Error: " . $e->getMessage());
                }
            }
        } finally {
            $stmt?->closeCursor();
            $dBConnection = null;
        }
        return [
            'isSuccessful' => false
        ];
    }

    public static function update(string $pSnakeId, string $pNewCustomerSnakeId, int $pUserId): array
    {
        $stmt = null; // Initialize $stmt outside the try block

        try {
            $dBConnection = openDatabaseConnection();
            $sql = "UPDATE customersnakename SET customer_snake_id = ? WHERE snake_id = ? AND user_id = ?";
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters after checking for empty strings
            $stmt->bindValue(1, $pNewCustomerSnakeId);
            $stmt->bindValue(2, $pSnakeId);
            $stmt->bindValue(3, $pUserId, PDO::PARAM_INT);

            // Check the number of affected rows to determine if the update was successful
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                return [
                    'isSuccessful' => true,
                    'rowCount' => $rowCount
                ];
            } else {
                return [
                    'isSuccessful' => false,
                    'error' => 'No records were updated. Please check if the provided snake_id and user_id combination exists.',
                ];
            }
        } catch (PDOException $e) {
            // Handle specific error conditions
            if ($e->getCode() == '23000') {
                // Check the error message for more detailed information
                if (str_contains($e->getMessage(), 'NOT NULL')) {
                    // Handle NOT NULL constraint violation
                    return [
                        'isSuccessful' => false,
                        'error' => 'NOT NULL constraint violation. Please provide values for all required fields.',
                    ];
                } elseif (str_contains($e->getMessage(), 'Duplicate entry')) {
                    // Handle duplicate key error
                    return [
                        'isSuccessful' => false,
                        'error' => 'Duplicate entry. The combination of snake_id and user_id must be unique.',
                    ];
                } else {
                    // Handle other errors
                    die("Error: " . $e->getMessage());
                }
            }
        } finally {
            $stmt?->closeCursor();
            $dBConnection = null;
        }

        return [
            'isSuccessful' => false
        ];
    }

    public static function delete(string $pSnakeId, int $pUserId): array
    {
        $stmt = null; // Initialize $stmt outside the try block

        try {
            $dBConnection = openDatabaseConnection();
            $sql = "DELETE FROM customersnakename WHERE snake_id = ? AND user_id = ?";
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters after checking for empty strings
            $stmt->bindValue(1, $pSnakeId);
            $stmt->bindValue(2, $pUserId, PDO::PARAM_INT);

            // Check the number of affected rows to determine if the delete was successful
            $rowCount = $stmt->rowCount();
            if ($rowCount > 0) {
                return [
                    'isSuccessful' => true,
                    'rowCount' => $rowCount
                ];
            } else {
                return [
                    'isSuccessful' => false,
                    'error' => 'No records were deleted. Please check if the provided snake_id and user_id combination exists.',
                ];
            }
        } catch (PDOException $e) {
            // Handle specific error conditions
            if ($e->getCode() == '23000') {
                // Check the error message for more detailed information
                if (str_contains($e->getMessage(), 'NOT NULL')) {
                    // Handle NOT NULL constraint violation
                    return [
                        'isSuccessful' => false,
                        'error' => 'NOT NULL constraint violation. Please provide values for all required fields.',
                    ];
                } elseif (str_contains($e->getMessage(), 'foreign key constraint fails')) {
                    // Handle foreign key constraint violation
                    return [
                        'isSuccessful' => false,
                        'error' => 'Foreign key constraint violation. Ensure that the provided snake_id and user_id combination exists.',
                    ];
                } else {
                    // Handle other errors
                    die("Error: " . $e->getMessage());
                }
            }
        } finally {
            $stmt?->closeCursor();
            $dBConnection = null;
        }

        return [
            'isSuccessful' => false
        ];
    }

    public function getCustomerSnakeId(): string
    {
        return $this->customerSnakeId;
    }

    public function setCustomerSnakeId(string $customerSnakeId): void
    {
        $this->customerSnakeId = $customerSnakeId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getSnakeId(): int
    {
        return $this->snakeId;
    }

    public function setSnakeId(int $snakeId): void
    {
        $this->snakeId = $snakeId;
    }
}
