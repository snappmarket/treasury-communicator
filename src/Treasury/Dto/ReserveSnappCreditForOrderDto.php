<?php

namespace SnappMarket\Treasury\Dto;

class ReserveSnappCreditForOrderDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    public function setOrderId(int $value)
    {
        $this->orderId = $value;

        return $this;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setCreatorId(int $value)
    {
        $this->creatorId = $value;

        return $this;
    }

    public function getCreatorId()
    {
        return $this->creatorId;
    }
}
