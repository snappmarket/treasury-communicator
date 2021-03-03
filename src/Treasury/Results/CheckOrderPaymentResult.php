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



    public function isPossible(): bool
    {
        return $this->isPossible;
    }



    public function getExtraCredit(): int
    {
        return $this->extraCredit;
    }


}
