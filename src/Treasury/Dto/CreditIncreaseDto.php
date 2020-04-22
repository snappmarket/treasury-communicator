<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 4/22/20
 * Time: 10:29 PM
 */

namespace SnappMarket\Treasury\Dto;


class CreditIncreaseDto
{
    /** @var int */
    private $userId;

    /** @var int */
    private $paymentId;

    /** @var int */
    private $value;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @param int $paymentId
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}