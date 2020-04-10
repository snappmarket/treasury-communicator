<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 4/10/20
 * Time: 9:49 PM
 */

namespace SnappMarket\Treasury\Dto;


class CreditUpdateDto
{
    /** @var int */
    private $userId;

    /** @var int */
    private $creatorId;

    /** @var int */
    private $deltaValue;

    /** @var string|null */
    private $walletType;

    /** @var string */
    private $comment;

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
    public function getDeltaValue()
    {
        return $this->deltaValue;
    }

    /**
     * @param int $deltaValue
     */
    public function setDeltaValue($deltaValue)
    {
        $this->deltaValue = $deltaValue;
    }

    /**
     * @return null|string
     */
    public function getWalletType()
    {
        return $this->walletType;
    }

    /**
     * @param null|string $walletType
     */
    public function setWalletType($walletType)
    {
        $this->walletType = $walletType;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }
}