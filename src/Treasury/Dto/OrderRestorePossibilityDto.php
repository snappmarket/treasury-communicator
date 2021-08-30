<?php

namespace SnappMarket\Treasury\Dto;

class OrderRestorePossibilityDto extends OrderPayDto
{
    /** @var int */
    private $orderId;

    /** @var float */
    private $voucherValue;

    /** @var float */
    private $giftCardValue;

    public function setOrderId(int $value): OrderRestorePossibilityDto
    {
        $this->orderId = $value;
        return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setVoucherValue(float $voucherValue): OrderRestorePossibilityDto
    {
        $this->voucherValue = $voucherValue;
        return $this;
    }

    public function getVoucherValue(): float
    {
        return $this->voucherValue;
    }

    public function setGiftCardValue(float $giftCardValue): OrderRestorePossibilityDto
    {
        $this->giftCardValue = $giftCardValue;
        return $this;
    }

    public function getGiftCardValue(): float
    {
        return $this->giftCardValue;
    }
}
