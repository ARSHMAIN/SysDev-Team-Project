<?php
class OrderStatus extends Model
{
    private int $orderStatusId;
    private string $orderStatusName;

    public function __construct(
        int $pOrderStatusId = -1,
        int $pOrderStatusName = -1
    ) {
        $this->initializeProperties(
            $pOrderStatusId,
            $pOrderStatusName
        );
    }
    private function initializeProperties(int $pOrderStatusId, int $pOrderStatusName): void
    {
        if ($pOrderStatusId < 0) return;
        else if (
            $pOrderStatusId > 0
            && $pOrderStatusName > 0
        ) {
            $this->orderStatusId = $pOrderStatusId;
            $this->orderStatusName = $pOrderStatusName;
        } else if ($pOrderStatusId > 0) {
            $this->getOrderStatusById($pOrderStatusId);
        }
    }
    private function getOrderStatusById(int $pOrderStatusId): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM orderstatus WHERE order_status_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pOrderStatusId, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->orderStatusId = $result['order_status_id'];
                $this->orderStatusName = $result['order_status_name'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }
    private function getOrderStatusByName(int $pOrderStatusName): void
    {
        $dBConnection = self::openDatabaseConnection();

        try {
            $sql = "SELECT * FROM orderstatus WHERE order_status_name = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pOrderStatusName, PDO::PARAM_STR);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->orderStatusId = $result['order_status_id'];
                $this->orderStatusName = $result['order_status_name'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }

    public function getOrderStatusId(): int
    {
        return $this->orderStatusId;
    }

    public function setOrderStatusId(int $orderStatusId): void
    {
        $this->orderStatusId = $orderStatusId;
    }

    public function getOrderStatusName(): string
    {
        return $this->orderStatusName;
    }

    public function setOrderStatusName(string $orderStatusName): void
    {
        $this->orderStatusName = $orderStatusName;
    }

}
