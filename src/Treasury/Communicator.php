<?php


namespace SnappMarket\Treasury;

use SnappMarket\Communicator\Communicator as BasicCommunicator;
use SnappMarket\Treasury\Dto\CreditUpdateDto;
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
             'creator_id'         => $orderUpdateDto->getCreatorId(),
             'old_delivery_fee'   => $orderUpdateDto->getOldDeliveryFee(),
             'old_products_price' => $orderUpdateDto->getOldProductsPrice(),
             'old_voucher_price'  => $orderUpdateDto->getOldVoucherPrice(),
        ]);

        return $response->getStatusCode() == 200;
    }

    public function storeCreditUpdate(CreditUpdateDto $creditUpdateDto)
    {
        $uri = 'api/credit/' . $creditUpdateDto->getUserId() . '/updates';
        $response = $this->post($uri, [
           'creator_id' => $creditUpdateDto->getCreatorId(),
           'delta_value' => $creditUpdateDto->getDeltaValue(),
           'wallet_type' => $creditUpdateDto->getWalletType(),
           'comment' => $creditUpdateDto->getComment()
        ]);
        return $response->getStatusCode() == 200;
    }
}
