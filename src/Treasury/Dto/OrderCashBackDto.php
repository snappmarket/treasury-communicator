<?php


namespace SnappMarket\Treasury\Dto;


class OrderCashBackDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    /** @var int */
    private $voucherId;



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



    public function setVoucherId(int $value)
    {
        $this->voucherId = $value;

        return $this;
    }



    public function getVoucherId()
    {
        return $this->voucherId;
    }
}
