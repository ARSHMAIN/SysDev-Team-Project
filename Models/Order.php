<?php
include_once 'database.php';

class Order
{
    private int $orderId;
    private bool $paymentStatus;
    private bool $seenStatus;
    private string $orderDate;
    private ?float $total;
    private int $userId;
    private int $orderStatusId;

    public function __construct(
        int    $pOrderId = -1,
        bool   $pPaymentStatus = false,
        bool   $pSeenStatus = false,
        string $pOrderDate = '',
        ?float  $pTotal = -1,
        int    $pUserId = -1,
        int    $pOrderStatusId = -1,

    )
    {
        $this->initializeProperties(
            $pOrderId,
            $pPaymentStatus,
            $pSeenStatus,
            $pOrderDate,
            $pTotal,
            $pUserId,
            $pOrderStatusId
        );
    }

    private function initializeProperties(
        int    $pOrderId,
        bool   $pPaymentStatus,
        bool   $pSeenStatus,
        string $pOrderDate,
        ?float  $pTotal,
        int    $pUserId,
        int    $pOrderStatusId
    ): void
    {
        if ($pOrderId < 0) return;
        else if (
            $pOrderId > 0
            && strlen($pOrderDate) > 0
            && $pTotal > 0
            && $pUserId > 0
            && $pOrderStatusId > 0
        ) {
            $this->orderId = $pOrderId;
            $this->paymentStatus = $pPaymentStatus;
            $this->seenStatus = $pSeenStatus;
            $this->orderDate = $pOrderDate;
            $this->total = $pTotal;
            $this->userId = $pUserId;
            $this->orderStatusId = $pOrderStatusId;
        } else if ($pOrderId > 0) {
            $this->getOrderById($pOrderId);
        }
    }

    private function getOrderById(int $pOrderId): void
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM `order` WHERE order_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pOrderId, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->orderId = $result['order_id'];
                $this->paymentStatus = $result['payment_status'];
                $this->seenStatus = $result['seen_status'];
                $this->orderDate = $result['order_date'];
                $this->total = $result['total'];
                $this->userId = $result['user_id'];
                $this->orderStatusId = $result['order_status_id'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public static function getOrderByUserId(int $pUserId)
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM `order` WHERE user_id = ? ORDER BY order_date DESC";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $orders = [];
                foreach ($results as $row) {
                    $order = new Order();
                    $order->orderId = $row['order_id'];
                    $order->paymentStatus = $row['payment_status'];
                    $order->seenStatus = $row['seen_status'];
                    $order->orderDate = $row['order_date'];
                    $order->total = $row['total'];
                    $order->userId = $row['user_id'];
                    $order->orderStatusId = $row['order_status_id'];
                    $orders[] = $order;
                }
                return $orders;
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

    public static function createOrder(bool $pPaymentStatus, bool $pSeenStatus, ?float $pTotal, int $pUserId, int $pOrderStatusId): array
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "INSERT INTO `order` (payment_status, seen_status ,total, user_id, order_status_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindValue(1, $pPaymentStatus, PDO::PARAM_BOOL);
            $stmt->bindValue(2, $pSeenStatus, PDO::PARAM_BOOL);
            $stmt->bindValue(3, $pTotal, PDO::PARAM_INT);
            $stmt->bindValue(4, $pUserId, PDO::PARAM_INT);
            $stmt->bindValue(5, $pOrderStatusId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();
            $newOrderId = $dBConnection->lastInsertId();

            return [
                'isSuccessful' => $isSuccessful,
                'newOrderId' => $newOrderId
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

    public static function updateOrder(int $pPaymentStatus, bool $pSeenStatus, ?float $pTotal, int $pUserId, int $pOrderStatusId, int $pOrderId): array
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "UPDATE `order` SET payment_status = ?, seen_status = ?, total = ?, user_id = ?, order_status_id = ? WHERE order_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindValue(1, $pPaymentStatus, PDO::PARAM_BOOL);
            $stmt->bindValue(2, $pSeenStatus, PDO::PARAM_BOOL);
            $stmt->bindValue(3, $pTotal, PDO::PARAM_INT);
            $stmt->bindValue(4, $pUserId, PDO::PARAM_INT);
            $stmt->bindValue(5, $pOrderStatusId, PDO::PARAM_INT);
            $stmt->bindValue(6, $pOrderId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();

            return [
                'isSuccessful' => $isSuccessful,
                'updatedOrderId' => $pOrderId
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

    public static function deleteOrder(int $pOrderId): array
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "DELETE FROM `order` WHERE order_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindValue(1, $pOrderId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();

            return [
                'isSuccessful' => $isSuccessful,
                'deletedOrderId' => $pOrderId
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

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    public function isPaymentStatus(): bool
    {
        return $this->paymentStatus;
    }

    public function setPaymentStatus(bool $paymentStatus): void
    {
        $this->paymentStatus = $paymentStatus;
    }

    public function isSeenStatus(): bool
    {
        return $this->seenStatus;
    }

    public function setSeenStatus(bool $seenStatus): void
    {
        $this->seenStatus = $seenStatus;
    }

    public function getOrderDate(): string
    {
        return $this->orderDate;
    }

    public function setOrderDate(string $orderDate): void
    {
        $this->orderDate = $orderDate;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(?float $total): void
    {
        $this->total = $total;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getOrderStatusId(): int
    {
        return $this->orderStatusId;
    }

    public function setOrderStatusId(int $orderStatusId): void
    {
        $this->orderStatusId = $orderStatusId;
    }

}