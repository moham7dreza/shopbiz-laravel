<?php

namespace Modules\Order\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class OrderResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message' => 'داده های مربوطه به سفارشات فروشگاه',
            'status' => 'success',
            'count' => count($this->collection),
            'data' => $this->collection->map(function ($order) {
                return [
                    'order_user_name' => $order->user->fullName,
                    'order_user_city' => $order->address->city->name,
                    'order_payment_type' => $order->paymentTypeValue(),
                    'order_payment_status' => $order->paymentStatusValue(),
//                    'order_payment_amount' => priceFormat($order->payment->amount),
                    'order_delivery_method' => $order->delivery->name,
                    'order_delivery_status' => $order->deliveryStatusValue(),
                    'order_delivery_date' => jalaliDate($order->delivery_date),
                    'order_final_amount' => priceFormat($order->order_final_amount),
                    'order_discount_amount' => priceFormat($order->order_discount_amount),
//                    'order_copan_amount' => priceFormat($order->copan->amount),
                    'order_copan_discount_amount' => priceFormat($order->order_copan_discount_amount),
//                    'order_common_discount_title' => priceFormat($order->commonDiscount->title),
                    'order_common_discount_amount' => priceFormat($order->order_common_discount_amount),
                    'order_total_products_discount_amount' => priceFormat($order->order_total_products_discount_amount),
                    'order_status' => $order->orderStatusValue(),
                    'order_creation_date' => jalaliDate($order->created_at),
                    'order_updating_date' => jalaliDate($order->updated_at),
                ];
            }),
        ];
    }
}
