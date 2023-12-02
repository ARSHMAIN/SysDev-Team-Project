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
        if ($pMorphId < 0) return;
        else if (
            $pCartId > 0
            && $pUserId > 0
        ) {
            $this->cartId = $pCartId;
            $this->userId = $pUserId;
        } else if ($pMorphId > 0) {
            $this->getById($pMorphId);
        }
    }
}