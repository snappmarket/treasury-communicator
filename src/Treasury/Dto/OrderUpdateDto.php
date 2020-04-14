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

    /** @var int|null */
    private $oldProductsPrice;

    /** @var int|null */
    private $oldVoucherPrice;



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



    public function setOldProductsPrice(?int $value)
    {
        $this->oldProductsPrice = $value;

        return $this;
    }



    public function getOldProductsPrice()
    {
        return $this->oldProductsPrice;
    }



    public function setOldVoucherPrice(?int $value)
    {
        $this->oldVoucherPrice = $value;

        return $this;
    }



    public function getOldVoucherPrice()
    {
        return $this->oldVoucherPrice;
    }
}
