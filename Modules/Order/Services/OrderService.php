<?php

namespace Modules\Order\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\Order;

class OrderService
{

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
