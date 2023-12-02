<?php
include_once 'database.php';

class Snake
{
    private int $snakeId = -1;
    private int $userId = -1;
    private int $sexId = -1;
    private string $snakeOrigin = "";

    public function __construct(
        int $pSnakeId = -1,
        int $pUserId = -1,
        int $pSexId = -1,
        string $pSnakeOrigin = ""
    ) {
        $this->initializeProperties(
            $pSnakeId,
            $pUserId,
            $pSexId,
            $pSnakeOrigin
        );
    }

    private function initializeProperties(
        int $pSnakeId,
        int $pUserId,
        int $pSexId,
        string $pSnakeOrigin
    ): void {
        if ($pSnakeId < 0) return;
        else if (
            $pSnakeId > 0
            && $pUserId > 0
            && $pSexId > 0
            && strlen($pSnakeOrigin) > 0
        ) {
            $this->snakeId = $pSnakeId;
            $this->userId = $pUserId;
            $this->sexId = $pSexId;
            $this->snakeOrigin = $pSnakeOrigin;
        } else if ($pSnakeId > 0) {
            $this->getSnakeById($pSnakeId);
        }
    }

    private function getSnakeById(int $pSnakeId): void
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM snake WHERE snake_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->snakeId = $pSnakeId;
                $this->userId = $result['user_id'];
                $this->sexId = $result['sex_id'];
                $this->snakeOrigin = $result['snake_origin'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getSnakesByUserId(int $pUserId): array
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM snake WHERE user_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);
            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $snakes = [];
            foreach ($results as $row) {
                $snake = new Snake(
                    $row['snake_id'],
                    $pUserId,
                    $row['sex_id'],
                    $row['snake_origin']
                );
                $snakes[] = $snake;
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }

        return $snakes;
    }

    public static function createSnake(int $pUserId, int $pSexId, string $pSnakeOrigin): array
    {
        $stmt = null; // Initialize $stmt outside the try block

        try {
            $dBConnection = openDatabaseConnection();
            $sql = "INSERT INTO snake (user_id, sex_id, snake_origin) VALUES (?, ?, ?)";
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters after checking for empty strings
            $stmt->bindValue(1, $pUserId, PDO::PARAM_INT);
            $stmt->bindValue(2, $pSexId, PDO::PARAM_INT);
            $stmt->bindValue(3, $pSnakeOrigin, PDO::PARAM_STR);

            $isSuccessful = $stmt->execute();
            $newSnakeId = $dBConnection->lastInsertId();

            return [
                'isSuccessful' => $isSuccessful,
                'newSnakeId' => $newSnakeId
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
                        'error' => 'Duplicate entry. The combination of user_id, sex_id, and snake_origin must be unique.',
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

    public static function updateSnake(int $pUserId, int $pSexId, string $pSnakeOrigin, int $pSnakeId): array
    {
        $stmt = null; // Initialize $stmt outside the try block

        try {
            $dBConnection = openDatabaseConnection();
            $sql = "UPDATE snake SET user_id = ?, sex_id = ?, snake_origin = ? WHERE snake_id = ?";
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters after checking for empty strings
            $stmt->bindValue(1, $pUserId, PDO::PARAM_INT);
            $stmt->bindValue(2, $pSexId, PDO::PARAM_INT);
            $stmt->bindValue(3, $pSnakeOrigin, PDO::PARAM_STR);
            $stmt->bindValue(4, $pSnakeId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();
            $stmt->close();

            return [
                'isSuccessful' => $isSuccessful,
                'updatedSnakeId' => $pSnakeId
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
                        'error' => 'Duplicate entry. The combination of user_id, sex_id, and snake_origin must be unique.',
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

    // TODO: delete only if test and donation do not have a record of snake_id
    public static function deleteSnakeById(int $pSnakeId): void
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "DELETE FROM snake WHERE snake_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
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

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getSexId(): int
    {
        return $this->sexId;
    }

    public function setSexId(int $sexId): void
    {
        $this->sexId = $sexId;
    }

    public function getSnakeOrigin(): string
    {
        return $this->snakeOrigin;
    }

    public function setSnakeOrigin(string $snakeOrigin): void
    {
        $this->snakeOrigin = $snakeOrigin;
    }
}