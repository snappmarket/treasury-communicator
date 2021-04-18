<?php


namespace SnappMarket\Treasury;

use Psr\Log\LoggerInterface;
use SnappMarket\Communicator\Communicator as BasicCommunicator;
use SnappMarket\Treasury\Dto\CheckOrderPaymentDto;
use SnappMarket\Treasury\Dto\CreditIncreaseDto;
use SnappMarket\Treasury\Dto\CreditPayBackDto;
use SnappMarket\Treasury\Dto\CreditUpdateDto;
use SnappMarket\Treasury\Dto\OrderCancelCreditReservationDto;
use SnappMarket\Treasury\Dto\OrderCancelDto;
use SnappMarket\Treasury\Dto\OrderCashBackDto;
use SnappMarket\Treasury\Dto\OrderPayDto;
use SnappMarket\Treasury\Dto\OrderReserveCreditDto;
use SnappMarket\Treasury\Dto\OrderUpdateDto;
use SnappMarket\Treasury\Dto\TransactionListDto;
use SnappMarket\Treasury\Results\CheckOrderPaymentResult;

class Communicator extends BasicCommunicator
{
    const SECURITY_TOKEN_HEADER = 'Service-Security';



    public function __construct(
         string $baseUri,
         array $headers = [],
         string $securityToken,
         ?LoggerInterface $logger = null
    ) {
        $headers[static::SECURITY_TOKEN_HEADER] = $securityToken;

        parent::__construct($baseUri, $headers, $logger);
    }



    public function storeOrderUpdate(OrderUpdateDto $orderUpdateDto)
    {
        $uri = 'api/v1/orders/' . $orderUpdateDto->getOrderId() . '/updates';

        $response = $this->request(static::METHOD_POST, $uri, [
             'creator_id'         => $orderUpdateDto->getCreatorId(),
             'old_delivery_fee'   => $orderUpdateDto->getOldDeliveryFee(),
             'old_products_price' => $orderUpdateDto->getOldProductsPrice(),
             'old_voucher_price'  => $orderUpdateDto->getOldVoucherPrice(),
        ]);

        return $response->getStatusCode() == 200;
    }



    public function storeOrderCancel(OrderCancelDto $orderCancelDto)
    {
        $uri = 'api/v1/orders/' . $orderCancelDto->getOrderId() . '/cancel';

        $response = $this->request(static::METHOD_POST, $uri, [
             'creator_id' => $orderCancelDto->getCreatorId(),
        ]);

        return $response->getStatusCode() == 200;
    }



    public function storeCreditUpdate(CreditUpdateDto $creditUpdateDto)
    {
        $uri      = 'api/v1/credit/' . $creditUpdateDto->getUserId() . '/updates';
        $response = $this->request(static::METHOD_POST, $uri, [
             'creator_id'  => $creditUpdateDto->getCreatorId(),
             'delta_value' => $creditUpdateDto->getDeltaValue(),
             'wallet_type' => $creditUpdateDto->getWalletType(),
             'comment'     => $creditUpdateDto->getComment(),
        ]);
        return $response->getStatusCode() == 200;
    }



    public function storeCreditIncrease(CreditIncreaseDto $creditIncreaseDto)
    {
        $uri      = 'api/v1/credit/' . $creditIncreaseDto->getUserId() . '/increase';
        $response = $this->request(static::METHOD_POST, $uri, [
             'value'      => $creditIncreaseDto->getValue(),
             'payment_id' => $creditIncreaseDto->getPaymentId(),
        ]);
        return $response->getStatusCode() == 200;
    }

    public function storeCreditPayBack(CreditPayBackDto $creditPayBackDto)
    {
        $uri      = 'api/v1/credit/' . $creditPayBackDto->getUserId() . '/payback';
        $response = $this->request(static::METHOD_POST, $uri, [
            'value' => $creditPayBackDto->getValue(),
            'creator_id' => $creditPayBackDto->getCreatorId(),
        ]);
        return $response->getStatusCode() == 200;
    }

    public function storeOrderPayment(OrderPayDto $orderPayDto): bool
    {
        $uri      = "api/v1/orders/{$orderPayDto->getOrderId()}/payments/{$orderPayDto->getPaymentId()}";
        $response = $this->request('put', $uri, [
             'payment_type' => $orderPayDto->getPaymentType(),
             'creator_id'   => $orderPayDto->getCreatorId(),
        ]);

        return $response->getStatusCode() == 200;
    }



    public function checkOrderPayment(CheckOrderPaymentDto $orderPayDto): CheckOrderPaymentResult
    {
        $uri      = "api/v1/orders/{$orderPayDto->getOrderId()}/payments/{$orderPayDto->getPaymentId()}/possibility";
        $response = $this->request(
            'get',
            $uri,
            [
                'payment_type'             => $orderPayDto->getPaymentType(),
                'creator_id'               => $orderPayDto->getCreatorId(),
                'unapplied_discount_value' => $orderPayDto->getUnnappliedPaymentType(),
            ]
        );

        $responseContent = $response->getBody()->__toString();
        $responseArray   = json_decode($responseContent, true);

        $isPossible  = $responseArray['metadata']['is_possible'];
        $extraCredit = $responseArray['metadata']['extra_credit'];

        return new CheckOrderPaymentResult($isPossible, $extraCredit);
    }



    public function reserveCreditForOrder(OrderReserveCreditDto $reserveCreditDto): int
    {
        $uri      = 'api/v1/orders/' . $reserveCreditDto->getOrderId() . '/credit-reservations';
        $response = $this->request(static::METHOD_POST, $uri, [
             'creator_id'   => $reserveCreditDto->getCreatorId(),
             'payment_type' => $reserveCreditDto->getPaymentType(),
        ]);

        $responseContent = $response->getBody()->__toString();
        $responseArray   = json_decode($responseContent, true);

        return $responseArray['metadata']['reserved_amount'];
    }



    public function cancelCreditReservationForOrder(OrderCancelCreditReservationDto $cancelCreditReservationDto): int
    {
        $uri      = 'api/v1/orders/' . $cancelCreditReservationDto->getOrderId() . '/credit-reservation-cancellations';
        $response = $this->request(static::METHOD_POST, $uri, [
             'creator_id'   => $cancelCreditReservationDto->getCreatorId(),
             'payment_type' => $cancelCreditReservationDto->getPaymentType(),
        ]);

        $responseContent = $response->getBody()->__toString();
        $responseArray   = json_decode($responseContent, true);

        return $responseArray['metadata']['freed_amount'];
    }

    public function storeCashBackTransactions(OrderCashBackDto $cashBackDto): int
    {
        $uri      = 'api/v1/orders/' . $cashBackDto->getOrderId() . '/cash-backs/' . $cashBackDto->getVoucherId();
        $response = $this->request(static::METHOD_POST, $uri, [
             'creator_id' => $cashBackDto->getCreatorId(),
        ]);

        $responseContent = $response->getBody()->__toString();
        $responseArray   = json_decode($responseContent, true);

        return $responseArray['metadata']['added_amount'];
    }

    public function getTransactionList(TransactionListDto $transactionListDto)
    {
        $uri = 'api/v1/transaction/' . $transactionListDto->getUserId();

        $response = $this->request(static::METHOD_GET, $uri, [
            'per_page' => $transactionListDto->getPerPage() ?: "",
            'page' => $transactionListDto->getPage() ?: "",
            'transaction_id' => $transactionListDto->getTransactionId() ?: "",
            '_from' => $transactionListDto->getFrom() ?: "",
            '_to' => $transactionListDto->getTo() ?: "",
            'value' => $transactionListDto->getValue() ?: "",
            'reason' => $transactionListDto->getReason() ?: "",
            'invoice_id' => $transactionListDto->getInvoiceId() ?: "",
            'support_agent_phone' => $transactionListDto->getSupportAgentPhone() ?: "",
            'comment' => $transactionListDto->getComment() ?: "",
        ]);

        $responseContent = $response->getBody()->__toString();
        $responseArray = json_decode($responseContent, true);

        return $responseArray;
    }

    public function getTransactionReasons()
    {
        $uri = 'api/v1/transaction/reasons';

        $response = $this->request(static::METHOD_GET, $uri, [
        ]);

        $responseContent = $response->getBody()->__toString();
        $responseArray = json_decode($responseContent, true);

        return $responseArray;
    }

    public function getTransactionMembers()
    {
        $uri = 'api/v1/transaction/members';

        $response = $this->request(static::METHOD_GET, $uri, [
        ]);

        $responseContent = $response->getBody()->__toString();
        $responseArray = json_decode($responseContent, true);

        return $responseArray;
    }
}
