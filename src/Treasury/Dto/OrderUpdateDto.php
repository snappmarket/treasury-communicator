<?php


namespace SnappMarket\Treasury\Dto;


class OrderUpdateDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    /** @var int|null */
    private $oldDeliveryFee;



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



    public function setOldDeliveryFee(?int $value)
    {
        $this->oldDeliveryFee = $value;

        return $this;
    }



    public function getOldDeliveryFee()
    {
        return $this->oldDeliveryFee;
    }
}
