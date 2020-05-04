<?php
/**
 * Created by PhpStorm.
 * User: pooria
 * Date: 5/1/20
 * Time: 10:22 PM
 */

namespace SnappMarket\Treasury\Dto;


class transactionListDto
{
    /** @var int|null */
    private $userId;

    /** @var int|null */
    private $perPage;

    /** @var int|null */
    private $page;

    /** @var int|null */
    private $transactionId;

    /** @var string|null */
    private $from;

    /** @var string|null */
    private $to;

    /** @var int|null */
    private $value;

    /** @var string|null */
    private $reason;

    /** @var int|null */
    private $invoiceId;

    /** @var string|null */
    private $supportAgentPhone;

    /** @var string|null */
    private $comment;

    /**
     * @return int|null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int|null $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return int|null
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param int|null $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * @return int|null
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * @param int|null $page
     */
    public function setPage($page)
    {
        $this->page = $page;
    }

    /**
     * @return int|null
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @param int|null $transactionId
     */
    public function setTransactionId($transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return null|string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param null|string $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return null|string
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param null|string $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return int|null
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int|null $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return null|string
     */
    public function getReason()
    {
        return $this->reason;
    }

    /**
     * @param null|string $reason
     */
    public function setReason($reason)
    {
        $this->reason = $reason;
    }

    /**
     * @return null|string
     */
    public function getSupportAgentPhone()
    {
        return $this->supportAgentPhone;
    }

    /**
     * @param null|string $supportAgentPhone
     */
    public function setSupportAgentPhone($supportAgentPhone)
    {
        $this->supportAgentPhone = $supportAgentPhone;
    }

    /**
     * @return null|string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param null|string $comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return int|null
     */
    public function getInvoiceId()
    {
        return $this->invoiceId;
    }

    /**
     * @param int|null $invoiceId
     */
    public function setInvoiceId($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }
}