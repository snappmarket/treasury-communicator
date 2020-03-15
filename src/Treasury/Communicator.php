<?php


namespace SnappMarket\Treasury;

use SnappMarket\Communicator\Communicator as BasicCommunicator;


class Communicator extends BasicCommunicator
{
    public function createOrderTransactions(int $orderId, string $paymentType, int $creatorId): bool
    {
        $response = $this->post("api/transaction", [
            'order_id' => $orderId,
            'payment_type' => $paymentType,
            'creator_id' => $creatorId
        ]);

        return $response->getStatusCode() == 200;
    }
}
