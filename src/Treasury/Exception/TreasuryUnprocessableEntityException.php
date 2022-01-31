
<?php

namespace SnappMarket\Treasury\Exception;

use Exception;

class TreasuryUnprocessableEntityException extends Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message, 422);
    }
}