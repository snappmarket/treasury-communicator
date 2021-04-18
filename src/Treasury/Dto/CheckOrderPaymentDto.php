<?php

namespace SnappMarket\Treasury\Dto;

use Modules\Order\Filters\OrderCheckPaymentPossibilityFilter;

class CheckOrderPaymentDto extends OrderPayDto
{
    private $unnappliedPaymentType = 0;



    public function getUnnappliedPaymentType(): int
    {
        return $this->unnappliedPaymentType;
    }



    public function setUnnappliedPaymentType(int $unnappliedPaymentType): CheckOrderPaymentDto
    {
        $this->unnappliedPaymentType = $unnappliedPaymentType;
        return $this;
    }


}
