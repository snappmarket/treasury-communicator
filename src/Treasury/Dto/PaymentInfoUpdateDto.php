<?php

namespace SnappMarket\Treasury\Dto;

use Exception;

class PaymentInfoUpdateDto
{
    const ACTION_PAID = 'paid';
    const ACTION_CANCELLED = 'cancel';
    const ACCEPTABLE_ACTIONS = [
        static::ACTION_PAID,
        static::ACTION_CANCELLED,
    ];

    /** @var int */
    private $paymentInfoId;

    /** @var int */
    private $creatorId;

    /** @var int */
    private $value;

    /** @var string */
    private $action;

    public function getPaymentInfoId(): int
    {
        return $this->paymentInfoId;
    }

    public function setPaymentInfoId(int $paymentInfoId): void
    {
        $this->paymentInfoId = $paymentInfoId;
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

    public function setAction(string $action): void
    {
        if (!in_array($action, static::ACCEPTABLE_ACTIONS)) {
            throw new Exception("Action is not valid.");
        }
        $this->action = $action;
    }

    public function getAction(): string
    {
        return $this->action;
    }
}
