<?php


namespace SnappMarket\Treasury;

use SnappMarket\Communicator\Communicator as BasicCommunicator;
use SnappMarket\Treasury\Dto\OrderUpdateDto;


class Communicator extends BasicCommunicator
{
    public function createOrderTransactions(int $orderId, string $paymentType, int $creatorId, int $paymentId): bool
    {
        $response = $this->post("api/transaction", [
            'order_id' => $orderId,
            'payment_type' => $paymentType,
            'creator_id' => $creatorId,
            'payment_id' => $paymentId
        ]);

        return $response->getStatusCode() == 200;
    }



    public function storeOrderUpdate(OrderUpdateDto $orderUpdateDto)
    {
        $uri = 'api/orders/' . $orderUpdateDto->getOrderId() . '/updates';

        $response = $this->post($uri, [
             'creator_id'       => $orderUpdateDto->getCreatorId(),
             'old_delivery_fee' => $orderUpdateDto->getOldDeliveryFee(),
        ]);

        return $response->getStatusCode() == 200;
    }
}
