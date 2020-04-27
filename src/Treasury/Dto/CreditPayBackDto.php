<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 4/27/20
 * Time: 5:29 PM
 */

namespace SnappMarket\Treasury\Dto;


class CreditPayBackDto
{
    /** @var int */
    private $userId;

    /** @var int */
    private $creatorId;

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
    public function getCreatorId()
    {
        return $this->creatorId;
    }

    /**
     * @param int $creatorId
     */
    public function setCreatorId($creatorId)
    {
        $this->creatorId = $creatorId;
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