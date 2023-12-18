<?php
include_once 'database.php';
class CartItem
{
    private int $cartItemId;
    private int $cartId;
    private int $userId;
    private ?int $donationId;
    private ?int $testId;
    public function __construct(
        int $pCartItemId = -1,
        int $pCartId = -1,
        int $pUserId = -1,
        ?int $pDonationId = -1,
        ?int $pTestId = -1
    ) {
        $this->initializeProperties(
            $pCartItemId,
            $pCartId,
            $pUserId,
            $pDonationId,
            $pTestId
        );
    }

    private function initializeProperties(
        int $pCartItemId,
        int $pCartId,
        int $pUserId,
        ?int $pDonationId,
        ?int $pTestId
    ): void
    {
        if ($pCartItemId < 0) return;
        else if (
            $pCartItemId > 0
            && $pCartId > 0
            && $pUserId > 0
            && $pDonationId > 0
            && $pTestId > 0
        ) {
            $this->cartItemId = $pCartItemId;
            $this->cartId = $pCartId;
            $this->userId = $pUserId;
            $this->donationId = $pDonationId;
            $this->testId = $pTestId;
        } else if ($pCartItemId > 0) {
            $this->getCartItemById($pCartItemId);
        }
    }

    private function getCartItemById(int $pCartItemId): void
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "SELECT * FROM cart_item WHERE cart_item_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pCartItemId, PDO::PARAM_INT);

            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $this->cartItemId = $result['cart_item_id'];
                $this->cartId = $result['cart_id'];
                $this->userId = $result['user_id'];
                $this->donationId = $result['donation_id'];
                $this->testId = $result['test_id'];
            }
        } catch (PDOException $e) {
            // Handle the exception as per your application's requirements
            die("Error: " . $e->getMessage());
        } finally {
            $stmt->closeCursor();
            $dBConnection = null;
        }

    }
    public static function geCartItemByCartIdAndUserId(int $pUserId)
    {
        $dBConnection = openDatabaseConnection();
        try {
            $sql = "SELECT * FROM cart_item WHERE cart_id = 1 AND user_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindParam(1, $pUserId, PDO::PARAM_INT);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                $cartItems = [];
                foreach ($results as $row) {
                    $cartItem = new CartItem();
                    $cartItem->cartItemId = $row['cart_item_id'];
                    $cartItem->cartId = $row['cart_id'];
                    $cartItem->userId = $row['user_id'];
                    $cartItem->donationId = $row['donation_id'];
                    $cartItem->testId = $row['test_id'];
                    $cartItems[] = $cartItem;
                }
                return $cartItems;
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
    public static function createCartItem(int $pUserId, ?int $pDonationId, ?int $pTestId): array
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "INSERT INTO cart_item (cart_id, user_id, donation_id, test_id) VALUES (1, ?, ?, ?)";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindValue(1, $pUserId, PDO::PARAM_INT);     // user_id
            $stmt->bindValue(2, $pDonationId, PDO::PARAM_INT); // donation_id
            $stmt->bindValue(3, $pTestId, PDO::PARAM_INT);     // test_id

            $isSuccessful = $stmt->execute();
            $newCartItemId = $dBConnection->lastInsertId();

            return [
                'isSuccessful' => $isSuccessful,
                'newCartItemId' => $newCartItemId
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
    public static function updateCartItem(int $pUserId, ?int $pDonationId, ?int $pTestId, int $pCartItemId): array
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "UPDATE cart_item SET user_id = ?, donation_id = ?, test_id = ? WHERE cart_item_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindValue(1, $pUserId, PDO::PARAM_INT);
            $stmt->bindValue(2, $pDonationId, PDO::PARAM_INT);
            $stmt->bindValue(3, $pTestId, PDO::PARAM_INT);
            $stmt->bindValue(4, $pCartItemId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();

            return [
                'isSuccessful' => $isSuccessful,
                'updatedCartItemId' => $pCartItemId
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
    public static function deleteCartItem(int $pCartItemId): array
    {
        $dBConnection = openDatabaseConnection();

        try {
            $sql = "DELETE FROM cart_item WHERE cart_item_id = ?";
            $stmt = $dBConnection->prepare($sql);

            $stmt->bindValue(1, $pCartItemId, PDO::PARAM_INT);

            $isSuccessful = $stmt->execute();

            return [
                'isSuccessful' => $isSuccessful,
                'deletedCartItemId' => $pCartItemId
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

    public function getCartItemId(): int
    {
        return $this->cartItemId;
    }

    public function setCartItemId(int $cartItemId): void
    {
        $this->cartItemId = $cartItemId;
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

    public function getDonationId(): ?int
    {
        return $this->donationId;
    }

    public function setDonationId(?int $donationId): void
    {
        $this->donationId = $donationId;
    }

    public function getTestId(): ?int
    {
        return $this->testId;
    }

    public function setTestId(?int $testId): void
    {
        $this->testId = $testId;
    }

}