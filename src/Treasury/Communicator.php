<?php


namespace SnappMarket\Treasury;

use Exception;
use Psr\Log\LoggerInterface;
use SnappMarket\Communicator\Communicator as BasicCommunicator;
use SnappMarket\Treasury\Dto\CheckOrderPaymentDto;
use SnappMarket\Treasury\Dto\CreditIncreaseDto;
use SnappMarket\Treasury\Dto\CreditPayBackDto;
use SnappMarket\Treasury\Dto\CreditUpdateDto;
use SnappMarket\Treasury\Dto\AlreadyRefundedAmountDto;
use SnappMarket\Treasury\Dto\PaidByGatewayDto;
use SnappMarket\Treasury\Dto\ReserveSnappCreditForOrderDto;
use SnappMarket\Treasury\Dto\OrderCancelCreditReservationDto;
use SnappMarket\Treasury\Dto\OrderCancelDto;
use SnappMarket\Treasury\Dto\OrderCashBackDto;
use SnappMarket\Treasury\Dto\OrderPayDto;
use SnappMarket\Treasury\Dto\OrderRamaUpdateDto;
use SnappMarket\Treasury\Dto\OrderReserveCreditDto;
use SnappMarket\Treasury\Dto\OrderRestoreDto;
use SnappMarket\Treasury\Dto\CancelSnappCreditReservationForOrderDto;
use SnappMarket\Treasury\Dto\OrderUpdateDto;
use SnappMarket\Treasury\Dto\PaymentInfoUpdateDto;
use SnappMarket\Treasury\Dto\ReturnCancelAmountToSnappCredit;
use SnappMarket\Treasury\Dto\ReturnedInstallmentAmountDto;
use SnappMarket\Treasury\Dto\ReturnSnappPayInstallmentAmountDto;
use SnappMarket\Treasury\Dto\StoreUserDebtDto;
use SnappMarket\Treasury\Dto\TransactionListDto;
use SnappMarket\Treasury\Results\CheckOrderPaymentResult;
use SnappMarket\Treasury\Dto\OrderRestorePossibilityDto;
use SnappMarket\Treasury\Dto\OrderReturnDto;
use SnappMarket\Treasury\Exception\TreasuryInternalServerErrorException;
use SnappMarket\Treasury\Exception\TreasuryUnprocessableEntityException;

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

        parent::__construct($baseUri, $headers, $logger, [
            'connect_timeout' => 5,
            'read_timeout' => 5,
            'timeout' => 5,
        ]);
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

    public function storeOrderRamaUpdate(OrderRamaUpdateDto $orderUpdateDto): bool
    {
        $uri = 'api/v1/orders/' . $orderUpdateDto->getOrderId() . '/rama-updates';

        $response = $this->request(static::METHOD_POST, $uri, [
            'creator_id'         => $orderUpdateDto->getCreatorId(),
            'old_products_price' => $orderUpdateDto->getOldProductsPrice(),
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
             'description' => $creditUpdateDto->getDescription(),
             'references_order_id' => $creditUpdateDto->getReferencesOrderId()
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
            'payment_info_id' => $creditPayBackDto->getPaymentInfoId(),
        ]);
        return $response->getStatusCode() == 200;
    }

    public function storeOrderPayment(OrderPayDto $orderPayDto): bool
    {
        $uri      = "api/v1/orders/{$orderPayDto->getOrderId()}/payments/{$orderPayDto->getPaymentId()}";
        $response = $this->request(static::METHOD_PUT, $uri, [
             'payment_type' => $orderPayDto->getPaymentType(),
             'creator_id'   => $orderPayDto->getCreatorId(),
        ]);

        return $response->getStatusCode() == 200;
    }

    public function checkOrderPayment(CheckOrderPaymentDto $orderPayDto): CheckOrderPaymentResult
    {
        $uri      = "api/v1/orders/{$orderPayDto->getOrderId()}/payments/{$orderPayDto->getPaymentId()}/possibility";
        $response = $this->request(
            static::METHOD_GET,
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


    public function checkRestoreOrderPayment(OrderRestorePossibilityDto $orderRestorePossibilityDto): bool
    {
        try {
            $uri      = "api/v1/orders/{$orderRestorePossibilityDto->getOrderId()}/restore-possibility";
            $response = $this->request(
                static::METHOD_GET,
                $uri,
                [
                    'voucher_value' => $orderRestorePossibilityDto->getVoucherValue(),
                    'giftcard_value' => $orderRestorePossibilityDto->getGiftCardValue(),
                ]
            );

            $responseContent = $response->getBody()->__toString();
            $responseArray   = json_decode($responseContent, true);

            return $responseArray['metadata']['is_possible'];
        } catch (Exception $e) {
            return false;
        }
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
            'description' => $transactionListDto->getDescription() ?: "",
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

    public function storePaymentInfoUpdate(PaymentInfoUpdateDto $paymentInfoUpdateDto): bool
    {
        $uri      = "api/v1/credit/payment-info-update";
        $response = $this->request(static::METHOD_POST, $uri, [
             'payment_info_id' => $paymentInfoUpdateDto->getPaymentInfoId(),
             'creator_id'   => $paymentInfoUpdateDto->getCreatorId(),
             'action' => $paymentInfoUpdateDto->getAction(),
        ]);

        return $response->getStatusCode() == 200;
    }

    public function restoreOrder(OrderRestoreDto $orderRestoreDto): bool
    {
        $uri      = "api/v1/orders/{$orderRestoreDto->getOrderId()}/restore";
        $response = $this->request(static::METHOD_POST, $uri, [
             'creator_id' => $orderRestoreDto->getCreatorId(),
             'giftcard_value' => $orderRestoreDto->getGiftCardValue(),
        ]);

        return $response->getStatusCode() == 200;
    }

    public function storeOrderReturn(OrderReturnDto $orderReturnDto): bool
    {
        try {
            $uri = 'api/v1/orders/' . $orderReturnDto->getOrderId() . '/return';

            $response = $this->request(static::METHOD_POST, $uri, [
                 'creator_id' => $orderReturnDto->getCreatorId(),
            ]);
    
            return $response->getStatusCode() == 200;
        } catch (Exception $e) {
            $responseContent = $response->getBody()->__toString();
            if ($response->getStatusCode() == 422) {
                throw new TreasuryUnprocessableEntityException($responseContent);
            }
            throw new TreasuryInternalServerErrorException($responseContent);
        }
    }

    public function userFullRefund(int $userId): array {
        try {
            $uri = 'api/v1/user/' . $userId . '/full-refund';

            $response = $this->request(static::METHOD_GET, $uri);
            $responseContent = $response->getBody()->__toString();
            $responseArray = json_decode($responseContent, true);
    
            return $responseArray;
        } catch (Exception $e) {
            $responseContent = $response->getBody()->__toString();
            if ($response->getStatusCode() == 422) {
                throw new TreasuryUnprocessableEntityException($responseContent);
            }
            throw new TreasuryInternalServerErrorException($e->getMessage());
        }
    }

    public function calculateRefundValue(int $userId, array $orderIds): array {
        try {
            $uri = 'api/v1/orders/calculate-refund';

            $response = $this->request(static::METHOD_GET, $uri, [
                'orders'    => $orderIds,
                'user_id'   => $userId,
            ]);
            $responseContent = $response->getBody()->__toString();
            $responseArray = json_decode($responseContent, true);
    
            return $responseArray;
        } catch (Exception $e) {
            $responseContent = $response->getBody()->__toString();
            if ($response->getStatusCode() == 422) {
                throw new TreasuryUnprocessableEntityException($responseContent);
            }
            throw new TreasuryInternalServerErrorException($e->getMessage());
        }
    }

    public function storeReserveSnappCreditForOrder(ReserveSnappCreditForOrderDto $dto): bool
    {
        $uri = 'api/v1/orders/' . $dto->getOrderId() . '/reserve-snappcredit';

        $response = $this->request(static::METHOD_POST, $uri, [
            'creator_id' => $dto->getCreatorId(),
        ]);

        return $response->getStatusCode() == 200;
    }

    public function storeCancelSnappCreditReservationForOrder(CancelSnappCreditReservationForOrderDto $dto): bool
    {
        $uri = 'api/v1/orders/' . $dto->getOrderId() . '/cancel-snappcredit-reservation';

        $response = $this->request(static::METHOD_POST, $uri, [
            'creator_id' => $dto->getCreatorId(),
        ]);

        return $response->getStatusCode() == 200;
    }

    public function returnCancelAmountToSnappCredit(ReturnCancelAmountToSnappCredit $dto): bool
    {
        $uri = 'api/v1/orders/' . $dto->getOrderId() . '/return-cancel-amount-to-snappcredit';

        $response = $this->request(static::METHOD_POST, $uri, [
            'creator_id' => $dto->getCreatorId(),
            'value' => $dto->getValue()
        ]);

        return $response->getStatusCode() == 200;
    }

    public function storeUserDebt(StoreUserDebtDto $dto): bool
    {
        $uri = 'api/v1/orders/user-debt/payment/' . $dto->getPaymentId();

        $response = $this->request(static::METHOD_POST, $uri, [
            'creator_id' => $dto->getCreatorId(),
        ]);

        return $response->getStatusCode() == 200;
    }

    public function getAlreadyRefundedAmount(AlreadyRefundedAmountDto $dto)
    {
        $uri = 'api/v1/orders/' . $dto->getOrderId() . '/already-refunded-amount';
        $response = $this->request(static::METHOD_GET, $uri);

        if ($response->getStatusCode() == 200){
            $responseContent = $response->getBody()->__toString();
            $responseArray = json_decode($responseContent, true);

            return $responseArray['results']['already_refunded_amount'] ?? false;
        }

        return false;
    }

    public function getPaidByGateway(PaidByGatewayDto $dto)
    {
        $uri = 'api/v1/orders/' . $dto->getOrderId() . '/paid-by-gateway';
        $response = $this->request(static::METHOD_GET, $uri);

        if ($response->getStatusCode() == 200){
            $responseContent = $response->getBody()->__toString();
            $responseArray = json_decode($responseContent, true);

            return $responseArray['results']['paid_by_gateway'] ?? false;
        }

        return false;
    }

    public function returnSnappPayInstallmentAmount(ReturnSnappPayInstallmentAmountDto $dto): bool
    {
        $uri = 'api/v1/orders/' . $dto->getOrderId() . '/return-snapppay-installment-amount';

        $response = $this->request(static::METHOD_POST, $uri, [
            'creator_id' => $dto->getCreatorId(),
            'value' => $dto->getValue(),
            'type' => $dto->getType()
        ]);

        return $response->getStatusCode() == 200;
    }

    public function getReturnedInstallmentAmount(ReturnedInstallmentAmountDto $dto)
    {
        $uri = 'api/v1/orders/' . $dto->getOrderId() . '/returned-installment-amount';
        $response = $this->request(static::METHOD_GET, $uri);

        if ($response->getStatusCode() == 200){
            $responseContent = $response->getBody()->__toString();
            $responseArray = json_decode($responseContent, true);

            return $responseArray['results']['returned_amount'] ?? false;
        }

        return false;
    }
}
