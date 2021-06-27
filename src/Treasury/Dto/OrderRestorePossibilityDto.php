<?php

namespace SnappMarket\Treasury\Dto;

class OrderRestorePossibilityDto extends OrderPayDto
{
    /** @var int */
    private $orderId;

    public function setOrderId(int $value): OrderRestorePossibilityDto
    {
        $this->orderId = $value;
        return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

}
