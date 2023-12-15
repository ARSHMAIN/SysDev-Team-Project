<?php
include_once 'database.php';
class Cart
{
    private int $cartId;
    private int $userId;
    public function __construct(
        int $pCartId = -1,
        int $pUserId = -1
    ) {
        $this->initializeProperties(
            $pCartId,
            $pUserId
        );
    }

    private function initializeProperties(int $pCartId, int $pUserId): void
    {
        if ($pUserId < 0) return;
        else if (
            $pCartId > 0
            && $pUserId > 0
        ) {
            $this->cartId = $pCartId;
            $this->userId = $pUserId;
        }
    }
    public static function getCartByUserId(int $pUserId): ?Cart
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM cart WHERE user_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $cart = new Cart();
                $cart->cartId = $result['cart_id'];
                $cart->userId = $result['user_id'];
                return $cart;
            }
            return null;
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            return null;
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }
    }
    public static function createCart(int $pUserId): array
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "INSERT INTO cart (user_id) VALUES (?)";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindValue(1, $pUserId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();
            $newCartId = $dBConnection->lastInsertId();

            return [
                'isSuccessful' => $isSuccessful,
                'newCartId' => $newCartId
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

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function setCartId(int $cartId): void
    {
        $this->cartId = $cartId;
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