<?php

namespace SnappMarket\Treasury\Dto;

class OrderRestoreDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    /** @var float */
    private $giftCardValue;

    public function setOrderId(int $value): OrderRestoreDto
    {
        $this->orderId = $value;
        return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setCreatorId(int $value): OrderRestoreDto
    {
        $this->creatorId = $value;

        return $this;
    }

    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

    public function setGiftCardValue(float $giftCardValue): OrderRestoreDto
    {
        $this->giftCardValue = $giftCardValue;
        return $this;
    }

    public function getGiftCardValue(): float
    {
        return $this->giftCardValue;
    }
}
