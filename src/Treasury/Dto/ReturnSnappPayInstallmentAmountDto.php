<?php

namespace SnappMarket\Treasury\Dto;

class ReturnSnappPayInstallmentAmountDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    /** @var int */
    private $value;

    /** @var string */
    private $type;

    public function setOrderId(int $value)
    {
        $this->orderId = $value;
        return $this;
    }

    public function getOrderId()
    {
        return $this->orderId;
    }

    public function setCreatorId(int $creatorId)
    {
        $this->creatorId = $creatorId;
        return $this;
    }

    public function getCreatorId()
    {
        return $this->creatorId;
    }

    public function setValue(int $value)
    {
        $this->value = $value;
        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }
}
