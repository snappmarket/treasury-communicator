<?php

namespace SnappMarket\Treasury\Dto;

class UpdateSnappCreditAmountForOrderDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    /** @var int */
    private $amount;

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

    public function setAmount(int $amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }
}
