<?php


namespace SnappMarket\Treasury\Dto;


class OrderReturnDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    public function setOrderId(int $value): OrderReturnDto
    {
        $this->orderId = $value;
        return $this;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function setCreatorId(int $value): OrderReturnDto
    {
        $this->creatorId = $value;
        return $this;
    }

    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

}
