<?php

namespace SnappMarket\Treasury\Results;

class CheckOrderPaymentResult
{
    private $isPossible;

    private $extraCredit;



    public function __construct(bool $isPossible, int $extraCredit)
    {
        $this->isPossible  = $isPossible;
        $this->extraCredit = $extraCredit;
    }



    public function getExtraCredit(): int
    {
        return $this->extraCredit;
    }



    public function setExtraCredit(int $extraCredit): void
    {
        $this->extraCredit = $extraCredit;
    }


}
