<?php

namespace SnappMarket\Treasury\Dto;

class OrderRamaUpdateDto
{
    /** @var int */
    private $orderId;

    /** @var int */
    private $creatorId;

    /** @var int|null */
    private $oldProductsPrice;



    public function getOrderId(): int
    {
        return $this->orderId;
    }



    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }



    public function getCreatorId(): int
    {
        return $this->creatorId;
    }



    public function setCreatorId(int $creatorId): self
    {
        $this->creatorId = $creatorId;

        return $this;
    }



    public function getOldProductsPrice(): ?int
    {
        return $this->oldProductsPrice;
    }



    public function setOldProductsPrice(?int $oldProductsPrice): self
    {
        $this->oldProductsPrice = $oldProductsPrice;

        return $this;
    }


}
