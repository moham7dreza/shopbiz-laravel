<?php

namespace Modules\Payment\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\CashPayment;
use Modules\Payment\Entities\OfflinePayment;
use Modules\Payment\Entities\OnlinePayment;
use Modules\Payment\Entities\Payment;

class PaymentService implements PaymentServiceInterface
{
    /**
     * @param $targetModel
     * @param $orderFinalAmount
     * @param $cash_receiver
     * @return mixed
     */
    public function storeTargetModel($targetModel, $orderFinalAmount, $cash_receiver): mixed
    {
        return $targetModel::query()->create([
            'amount' => $orderFinalAmount,
            'user_id' => auth()->id(),
            'pay_date' => now(),
            'cash_receiver' => $cash_receiver,
            'status' => $targetModel::STATUS_ACTIVE,
        ]);
    }

    /**
     * @param $request
     * @return array|RedirectResponse
     */
    public function findTargetModel($request): array|RedirectResponse
    {
        // only for cash payments -> whose receive cash
        $cash_receiver = null;

        switch ($request->payment_type) {
            case '1':
                $targetModel = OnlinePayment::class;
                $type = 0;
                break;
            case '2':
                $targetModel = OfflinePayment::class;
                $type = 1;
                break;
            case '3':
                $targetModel = CashPayment::class;
                $type = 2;
                $cash_receiver = $request->cash_receiver ? $request->cash_receiver : null;
                break;
            default:
                return redirect()->back()->withErrors(['error' => 'خطا']);
        }
        return [
            'targetModel' => $targetModel,
            'type' => $type,
            'cashReceiver' => $cash_receiver
        ];
    }

    /**
     * @param $orderFinalAmount
     * @param $type
     * @param $paymentedId
     * @param $targetModel
     * @return Model|Builder
     */
    public function store($orderFinalAmount, $type, $paymentedId, $targetModel): Model|Builder
    {
        return $this->query()->create([
            'amount' => $orderFinalAmount,
            'user_id' => auth()->id(),
            'type' => $type,
            'paymentable_id' => $paymentedId,
            'paymentable_type' => $targetModel,
            'status' => Payment::PAYMENT_STATUS_PAID,
        ]);
    }

    /**
     * @param $payment
     * @return void
     */
    public function makePaymentCanceled($payment): void
    {
        $payment->status = Payment::PAYMENT_STATUS_CANCELED;
        $payment->save();
    }

    /**
     * @param $payment
     * @return void
     */
    public function makePaymentReturned($payment): void
    {
        $payment->status = Payment::PAYMENT_STATUS_RETURNED;
        $payment->save();
    }

    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return Payment::query();
    }
//    /**
//     * Generate payments.
//     *
//     * @param  string $amount
//     * @param  object $paymentable
//     * @param  User $buyer
//     * @param  int|string|null $seller_id
//     * @param  array $discounts
//     * @return false|RedirectResponse|Payment
//     */
//    public function generate(
//        string $amount,
//        object $paymentable,
//        User $buyer,
//        int|string $seller_id = null,
//        array $discounts = []
//    ) {
//        if ($amount <= 0 || is_null($paymentable->id) || is_null($buyer->id)) {
//            return false;
//        }
//
//        $gateway = resolve(Gateway::class);
//        $invoiceId = $gateway->request($amount, $paymentable->title);
//        if (is_array($invoiceId)) {
//            return back();
//        }
//
//        if (is_null($paymentable->percent)) {
//            $seller_p = $paymentable->percent;
//            $seller_share = ($amount / 100 * $seller_p);
//            $site_share = $amount - $seller_share;
//        } else {
//            $seller_p = $seller_share = 0;
//            $site_share = $amount;
//        }
//
//        return $this->store([
//            'buyer_id' => $buyer->id,
//            'seller_id' => $seller_id,
//            'paymentable_id' => $paymentable->id,
//            'paymentable_type' => get_class($paymentable),
//            'amount' => $amount,
//            'invoice_id' => $invoiceId,
//            'gateway' => $gateway->getName(),
//            'status' => PaymentStatusEnum::STATUS_PENDING->value,
//            'seller_p' => $seller_p,
//            'seller_share' => $seller_share,
//            'site_share' => $site_share,
//        ], $discounts);
//    }
//
//    /**
//     * Change status by id.
//     *
//     * @param  int $id
//     * @param  string $status
//     * @return int
//     */
//    public function changeStatus(int $id, string $status)
//    {
//        return Payment::query()
//            ->where('id', $id)
//            ->update(['status' => $status]);
//    }
//
//    # Private methods
//
//    /**
//     * Store payments.
//     *
//     * @param  array $data
//     * @param  array $discounts
//     * @return Payment
//     */
//    private function store(array $data, array $discounts = [])
//    {
//        $payments = Payment::query()->create([
//            "buyer_id"          => $data['buyer_id'],
//            "paymentable_id"    => $data['paymentable_id'],
//            "paymentable_type"  => $data['paymentable_type'],
//            "amount"            => $data['amount'],
//            "seller_id"         => $data['seller_id'],
//            "invoice_id"        => $data['invoice_id'],
//            "gateway"           => $data['gateway'],
//            "status"            => $data['status'],
//            "seller_p"          => $data['seller_p'],
//            "seller_share"      => $data['seller_share'],
//            "site_share"        => $data['site_share'],
//        ]);
//        $this->syncDiscountToPayments($payments, $discounts);
//
//        return $payments;
//    }
//
//    /**
//     * Sync discount to payments.
//     *
//     * @param  Payment $payments
//     * @param  array $discounts
//     * @return Payment
//     */
//    private function syncDiscountToPayments(Payment $payments, array $discounts = [])
//    {
//        foreach ($discounts as $discount) {
//            $discountIds[] = $discount->id;
//        }
//        if (isset($discountIds)) {
//            $payments->discounts()->sync($discountIds);
//        }
//
//        return $payments;
//    }
}
