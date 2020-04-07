<?php


namespace SnappMarket\Treasury\Dto;


class OrderUpdateDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    /** @var int|null */
    private $newDeliveryFee;



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



    public function setNewDeliveryFee(?int $value)
    {
        $this->newDeliveryFee = $value;

        return $this;
    }



    public function getNewDeliveryFee()
    {
        return $this->newDeliveryFee;
    }
}
