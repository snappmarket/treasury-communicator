<?php

namespace SnappMarket\Treasury\Dto;

class AlreadyRefundedAmountDto
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
