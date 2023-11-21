<?php

namespace Models;
include_once 'database.php';
class Snake
{
    private int $snakeId = -1;
    private int $userId = -1;
    private int $sexId = -1;
    private string $snakeOrigin = "";

    function __construct(
        $pSnakeId = -1,
        $pUserId = -1,
        $pSexId = -1,
        $pSnakeOrigin = ""
    ) {
        $this->initializeProperties(
            $pSnakeId,
            $pUserId,
            $pSexId,
            $pSnakeOrigin
        );
    }

    private function initializeProperties(
        $pSnakeId,
        $pUserId,
        $pSexId,
        $pSnakeOrigin
    ): void
    {
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

    private function getSnakeById($pSnakeId): void
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM snake WHERE snake_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pSnakeId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $result = $result->fetch_assoc();
            $this->snakeId = $pSnakeId;
            $this->userId = $result['user_id'];
            $this->sexId = $result['sex_id'];
            $this->snakeOrigin = $result['snake_origin'];
        }
    }
    public static function getSnakesByUserId($pUserId): array
    {
        $dBConnection = openDatabaseConnection();
        $sql = "SELECT * FROM snake WHERE user_id = ?";
        $stmt = $dBConnection->prepare($sql);
        $stmt->bind_param('i', $pUserId);
        $stmt->execute();
        $results = $stmt->get_result();
        $snakes = [];
        if ($results->num_rows > 0) {
            while ($row = $results->fetch_assoc()){
                $snake = new Snake();
                $snake->snakeId = $row['snake_id'];
                $snake->userId = $pUserId;
                $snake->sexId = $row['sex_id'];
                $snake->snakeOrigin = $row['snake_origin'];
                $snakes[] = $snake;
            }
        }
        return $snakes;
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