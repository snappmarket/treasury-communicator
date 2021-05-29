<?php

namespace SnappMarket\Treasury\Dto;

class CreditPayBackDto
{
    /** @var int */
    private $userId;

    /** @var int */
    private $creatorId;

    /** @var int */
    private $value;

    /** @var int */
    private $paymentInfoId;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getCreatorId(): int
    {
        return $this->creatorId;
    }

    public function setCreatorId(int $creatorId): void
    {
        $this->creatorId = $creatorId;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getPaymentInfoId(): int
    {
        return $this->paymentInfoId;
    }

    public function setPaymentInfoId(int $paymentInfoId): void
    {
        $this->paymentInfoId = $paymentInfoId;
    }
}
