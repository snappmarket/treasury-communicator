<?php

namespace SnappMarket\Treasury\Dto;

class StoreUserDebtDto
{
    /** @var int */
    private $paymentId;

    /** @var int */
    private $creatorId;

    public function setPaymentId(int $value)
    {
        $this->paymentId = $value;

        return $this;
    }

    public function getPaymentId()
    {
        return $this->paymentId;
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
