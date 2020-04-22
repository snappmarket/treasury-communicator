<?php


namespace SnappMarket\Treasury\Dto;


class OrderPayDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    /** @var string */
    private $paymentType;

    /** @var int */
    private $paymentId;



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



    public function setPaymentType(string $value)
    {
        $this->paymentType = $value;

        return $this;
    }



    public function getPaymentType()
    {
        return $this->paymentType;
    }



    public function setPaymentId(int $value)
    {
        $this->paymentId = $value;

        return $this;
    }



    public function getPaymentId()
    {
        return $this->paymentId;
    }
}
