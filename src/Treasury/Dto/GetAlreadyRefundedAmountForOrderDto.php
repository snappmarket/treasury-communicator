<?php

namespace SnappMarket\Treasury\Dto;

class GetAlreadyRefundedAmountForOrderDto
{
    /** @var int */
    private $orderId;

    public function setOrderId(int $value)
    {
        $this->orderId = $value;

        return $this;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }
}
