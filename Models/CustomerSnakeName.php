<?php


include_once 'database.php';

class CustomerSnakeName
{
    private string $customerSnakeId = '';
    private int $userId = -1;
    private int $snakeId = -1;

    function __construct(
        $pCustomerSnakeId = "",
        $pUserId = -1,
        $pSnakeId = -1
    ) {
        $this->initializeProperties(
            $pCustomerSnakeId,
            $pUserId,
            $pSnakeId
        );
    }

    private function initializeProperties(
        $pCustomerSnakeId,
        $pUserId,
        $pSnakeId,
    ): void
    {
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
            $this->getCustomerSnakeNameBySnakeId($pSnakeId);
        }
    }

    private function getCustomerSnakeNameBySnakeId($pSnakeId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM customersnakename WHERE snake_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pSnakeId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $this->customerSnakeId = $result['customer_snake_id'];
            $this->userId = $result['user_id'];
            $this->snakeId = $pSnakeId;
        }
    }
    public static function createCustomerSnakeName(string $pCustomerSnakeId, int $pUserId, int $pSnakeId): array
    {
        $dBConnection = openDatabaseConnection();
        $sql = "INSERT INTO customersnakename (customer_snake_id, user_id, snake_id) VALUES (?, ?, ?)";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('sii', $pCustomerSnakeId, $pUserId, $pSnakeId);
        $isSuccessful = $stmt->execute();
        $customerSnakeId = $dBConnection->insert_id;
        $stmt->close();
        $dBConnection->close();
        return [
            'isSuccessful' => $isSuccessful,
            'newCustomerSnakeId' => $customerSnakeId
        ];
    }
    public static function updateCustomerSnakeName(string $pCustomerSnakeId, int $pUserId, int $pSnakeId): array
    {
        $dBConnection = openDatabaseConnection();
        $sql = "UPDATE customersnakename SET customer_snake_id = ? WHERE snake_id = ? AND user_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('sii', $pCustomerSnakeId, $pUserId, $pSnakeId);
        $isSuccessful = $stmt->execute();
        $stmt->close();
        $dBConnection->close();
        return [
            'isSuccessful' => $isSuccessful,
            'updatedCustomerSnakeId' => $pCustomerSnakeId
        ];
    }
    public static function deleteCustomerSnakeName(string $pCustomerSnakeId, int $pSnakeId, int $pUserId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "DELETE FROM customersnakename WHERE customer_snake_id = ? AND snake_id = ? AND user_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('sii', $pCustomerSnakeId, $pSnakeId, $pUserId);
        $stmt->execute();
        $stmt->close();
        $dBConnection->close();
    }
    public function getCustomerSnakeId(): int
    {
        return $this->customerSnakeId;
    }

    public function setCustomerSnakeId(int $customerSnakeId): void
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