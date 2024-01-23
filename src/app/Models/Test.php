<?php

namespace MyApp\Models;

use Config\Database;
use PDO;
use PDOException;

class Test extends Database
{
    private int $testId;
    private int $snakeId;
    private ?int $orderId;
    private int $userId;

    public function __construct(
        int  $pTestId = -1,
        int  $pSnakeId = -1,
        ?int $pOrderId = -1,
        int  $pUserId = -1
    )
    {
        $this->initializeProperties(
            $pTestId,
            $pSnakeId,
            $pOrderId,
            $pUserId
        );
    }

    private function initializeProperties(
        int  $pTestId,
        int  $pSnakeId,
        ?int $pOrderId,
        int  $pUserId
    ): void
    {
        if ($pTestId < 0) return;
        else if (
            $pTestId > 0
            && $pSnakeId > 0
            && $pOrderId > 0
            && $pUserId > 0
        ) {
            $this->testId = $pTestId;
            $this->snakeId = $pSnakeId;
            $this->orderId = $pOrderId;
            $this->userId = $pUserId;
        } else if ($pTestId > 0) {
            $this->getById($pTestId);
        }
    }

    private function getById(int $pTestId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM test WHERE test_id = ?";
            $stmt = $dBConnection->prepare($sql);
            $stmt->bindParam(1, $pTestId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->testId = $result['test_id'];
                $this->snakeId = $result['snake_id'];
                $this->orderId = $result['order_id'];
                $this->userId = $result['user_id'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getBySnakeId(int $pSnakeId): array
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM test WHERE snake_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $tests = [];
                foreach ($results as $row) {
                    $test = new Test(
                        $row['test_id'],
                        $row['snake_id'],
                        $row['order_id'],
                        $row['user_id']
                    );
                    $tests[] = $test;
                }
                return [
                    'isSuccessful' => $isSuccessful,
                    'tests' => $tests,
                    'rowCount' => $stmt->rowCount()
                ];
            }
            return [
                'isSuccessful' => false,
                'tests' => null
            ];
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            return [
                'isSuccessful' => false,
                'error' => "Error: " . $e->getMessage()
            ];
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getBySnakeIdAndOrderExists(int $pSnakeId)
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM test WHERE snake_id = ? AND order_id IS NOT NULL";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pSnakeId, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($stmt->rowCount() > 0) {
                $tests = [];
                foreach ($results as $row) {
                    $test = new Test();
                    $test->testId = $row['test_id'];
                    $test->snakeId = $row['snake_id'];
                    $test->orderId = $row['order_id'];
                    $test->userId = $row['user_id'];
                    $tests[] = $test;
                }
                return $tests;
            }
            return null;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getByOrderId(int $pOrderId): ?array
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM test WHERE order_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pOrderId, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $tests = [];
                foreach ($results as $row) {
                    $test = new Test();
                    $test->testId = $row['test_id'];
                    $test->snakeId = $row['snake_id'];
                    $test->orderId = $row['order_id'];
                    $test->userId = $row['user_id'];
                    $tests[] = $test;
                }
                return $tests;
            }
            return null;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function create(int $pSnakeId, int $pUserId): array
    {
        $stmt = null; // Initialize $stmt outside the try block

        try {
            $dBConnection = self::openDatabaseConnection();
            $sql = "INSERT INTO test (snake_id, user_id) VALUES (?, ?)";
            $stmt = $dBConnection->prepare($sql);

            // Bind parameters after checking for empty strings
            $stmt->bindValue(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->bindValue(2, $pUserId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();
            $newTestId = $dBConnection->lastInsertId();

            return [
                'isSuccessful' => $isSuccessful,
                'newTestId' => $newTestId
            ];
        } catch (PDOException $e) {
            // Handle specific error conditions
            var_dump($e->getMessage());
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

    public static function updateTest($pSnakeId, $pOrderId, $pUserId, $pTestId): array
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "UPDATE test SET snake_id = ?, order_id = ?, user_id = ? WHERE test_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindValue(1, $pSnakeId, PDO::PARAM_INT);
            $stmt->bindValue(2, $pOrderId, PDO::PARAM_INT);
            $stmt->bindValue(3, $pUserId, PDO::PARAM_INT);
            $stmt->bindValue(4, $pTestId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();

            return [
                'isSuccessful' => $isSuccessful,
                'updatedTestId' => $pTestId
            ];
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            return [
                'isSuccessful' => false,
                'error' => $e->getMessage()
            ];
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function deleteTest(int $pTestId): array
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "DELETE FROM test WHERE test_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindValue(1, $pTestId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();

            return [
                'isSuccessful' => $isSuccessful,
                'deletedTestId' => $pTestId
            ];
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            return [
                'isSuccessful' => false,
                'error' => $e->getMessage()
            ];
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public function getTestId(): int
    {
        return $this->testId;
    }

    public function setTestId(int $testId): void
    {
        $this->testId = $testId;
    }

    public function getSnakeId(): int
    {
        return $this->snakeId;
    }

    public function setSnakeId(int $snakeId): void
    {
        $this->snakeId = $snakeId;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }

    public function setOrderId(?int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

}