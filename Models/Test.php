<?php
include_once 'database.php';
class Test
{
    private int $testId;
    private int $snakeId;
    private int $orderId;
    private int $userId;
    public function __construct(
        int $pTestId = -1,
        int $pSnakeId = -1,
        int $pOrderId = -1,
        int $pUserId = -1
    ) {
        $this->initializeProperties(
            $pTestId,
            $pSnakeId,
            $pOrderId,
            $pUserId
        );
    }

    private function initializeProperties(
        int $pTestId,
        int $pSnakeId,
        int $pOrderId,
        int $pUserId
    ): void {
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
        $dBConnection = openDatabaseConnection();

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
    public static function create(int $pSnakeId, int $pUserId): array
    {
        $stmt = null; // Initialize $stmt outside the try block

        try {
            $dBConnection = openDatabaseConnection();
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
}