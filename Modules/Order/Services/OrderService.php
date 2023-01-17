<?php

namespace Modules\Order\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderItem;

class OrderService
{

    /**
     * @param $cartItems
     * @param $orderId
     * @return void
     */
    public function addOrderItemsAndDeleteAllCartItems($cartItems, $orderId): void
    {
        foreach ($cartItems as $cartItem) {
            OrderItem::query()->create([
                'order_id' => $orderId,
                'product_id' => $cartItem->product_id,
                'product' => $cartItem->product,
                'amazing_sale_id' => $cartItem->product->activeAmazingSales()->id ?? null,
                'amazing_sale_object' => $cartItem->product->activeAmazingSales() ?? null,
                'amazing_sale_discount_amount' => empty($cartItem->product->activeAmazingSales()) ? 0 : $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100),
                'number' => $cartItem->number,
                'final_product_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)),
                'final_total_price' => empty($cartItem->product->activeAmazingSales()) ? $cartItem->cartItemProductPrice() * ($cartItem->number) : ($cartItem->cartItemProductPrice() - $cartItem->cartItemProductPrice() * ($cartItem->product->activeAmazingSales()->percentage / 100)) * ($cartItem->number),
                'color_id' => $cartItem->color_id,
                'guarantee_id' => $cartItem->guarantee_id,
            ]);
            $cartItem->delete();
        }
    }

    public function addOrderItems($order, $cartItems)
    {
        global $inputs;
        foreach ($cartItems as $cartItem) {
            $cartItemActiveAmazingSales = $cartItem->product->activeAmazingSales();
            $cartItemActiveAmazingSalesDiscountAmount = empty($cartItemActiveAmazingSales) ? 0 :
                $cartItem->cartItemProductPrice() * ($cartItemActiveAmazingSales->percentage / 100);
            $finalProductPrice = $cartItem->cartItemProductPrice() - $cartItemActiveAmazingSalesDiscountAmount;
            $finalTotalPrice = $finalProductPrice * $cartItem->number;

            $inputs['order_id'] = $order->id;
            $inputs['product_id'] = $cartItem->product_id;
            $inputs['product'] = $cartItem->product;
            $inputs['number'] = $cartItem->number;
            $inputs['color_id'] = $cartItem->color_id ?? null;
            $inputs['guarantee_id'] = $cartItem->guarantee_id ?? null;
            $inputs['amazing_sale_id'] = $cartItemActiveAmazingSales->id ?? null;
            $inputs['amazing_sale_object'] = $cartItemActiveAmazingSales ?? null;
            $inputs['amazing_sale_discount_amount'] = $cartItemActiveAmazingSalesDiscountAmount ?? null;
            $inputs['final_product_price'] = $finalProductPrice;
            $inputs['final_total_price'] = $finalTotalPrice;

            OrderItem::query()->create($inputs);
        }
    }

    /**
     * @param $order
     * @param $type
     * @param $paymentId
     * @return mixed
     */
    public function lastStepUpdate($order, $type, $paymentId): mixed
    {
        return $order->update([
            'order_status' => Order::ORDER_STATUS_CONFIRMED,
            'payment_type' => $type,
            'payment_id' => $paymentId,
            'payment_status' => Order::PAYMENT_STATUS_PAID,
            'delivery_status' => Order::DELIVERY_STATUS_SENDING,
            'delivery_date' => now()
        ]);
    }

    /**
     * @param $order
     * @param $copanDiscountAmount
     * @param $copanId
     * @return mixed
     */
    public function update($order, $copanDiscountAmount, $copanId): mixed
    {
        $order->order_final_amount = $order->order_final_amount - $copanDiscountAmount;
        $finalDiscount = $order->order_total_products_discount_amount + $copanDiscountAmount;
        return $order->update([
            'copan_id' => $copanId,
            'order_copan_discount_amount' => $copanDiscountAmount,
            'order_total_products_discount_amount' => $finalDiscount
        ]);
    }

    /**
     * @param $copan
     * @param int $orderFinalAmount
     * @return float|int|mixed
     */
    public function calcCopanDiscountAmount($copan, int $orderFinalAmount): mixed
    {
        // The copan discount is a percentage
        if ($copan->amount_type == 0) {
            $copanDiscountAmount = $orderFinalAmount * ($copan->amount / 100);
            if ($copanDiscountAmount > $copan->discount_ceiling) {
                $copanDiscountAmount = $copan->discount_ceiling;
            }
        } // The copan discount is numerical
        else {
            $copanDiscountAmount = $copan->amount;
        }
        return $copanDiscountAmount;
    }

    /**
     * @param $commonDiscount
     * @param $selectedAddress
     * @param $selectedDeliveryMethod
     * @param $calculatedPrices
     * @return Model|Builder
     */
    public function updateOrCreate($commonDiscount, $selectedAddress, $selectedDeliveryMethod, $calculatedPrices): Model|Builder
    {
        return $this->query()->updateOrCreate(
            [
                'user_id' => auth()->id(),
                'order_status' => Order::ORDER_STATUS_NOT_CHECKED
            ],
            [
                'user_id' => auth()->id(),
                'address_id' => $selectedAddress->id ?? null,
                'delivery_id' => $selectedDeliveryMethod->id ?? null,
                'delivery_amount' => $selectedDeliveryMethod->amount ?? null,
                'order_final_amount' => $calculatedPrices['order_final_amount'] ?? 0,
                'order_discount_amount' => $calculatedPrices['order_discount_amount'] ?? 0,
                'order_common_discount_amount' => $calculatedPrices['order_common_discount_amount'] ?? 0,
                'order_total_products_discount_amount' => $calculatedPrices['order_discount_amount'] + $calculatedPrices['order_common_discount_amount'] ?? 0,
                'common_discount_id' => $commonDiscount ? $commonDiscount->id : null,
            ]
        );
    }

    /**
     * @param $cartItems
     * @param $commonDiscount
     * @return array
     */
    public function calcPrice($cartItems, $commonDiscount): array
    {
        $totalProductPrice = 0;
        $totalDiscount = 0;
        $totalFinalPrice = 0;
        $totalFinalDiscountPriceWithNumbers = 0;

        // for each product in user cart -> calculate price for products
        foreach ($cartItems as $cartItem) {
            $totalProductPrice += $cartItem->cartItemProductPrice();
            $totalDiscount += $cartItem->cartItemProductDiscount();
            $totalFinalPrice += $cartItem->cartItemFinalPrice();
            $totalFinalDiscountPriceWithNumbers += $cartItem->cartItemFinalDiscount();
        }
        // if active common discount is exists
        if ($commonDiscount) {
            $commonPercentageDiscountAmount = $totalFinalPrice * ($commonDiscount->percentage / 100);
            if ($commonPercentageDiscountAmount > $commonDiscount->discount_ceiling) {
                $commonPercentageDiscountAmount = $commonDiscount->discount_ceiling;
            }
            if ($totalFinalPrice >= $commonDiscount->minimal_order_amount) {
                $finalPrice = $totalFinalPrice - $commonPercentageDiscountAmount;
            } else {
                $finalPrice = $totalFinalPrice;
            }
        } else {
            $commonPercentageDiscountAmount = null;
            $finalPrice = $totalFinalPrice;
        }
        return [
            'order_final_amount' => $finalPrice,
            'order_discount_amount' => $totalFinalDiscountPriceWithNumbers,
            'order_common_discount_amount' => $commonPercentageDiscountAmount
        ];
    }

    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return Order::query();
    }
}
