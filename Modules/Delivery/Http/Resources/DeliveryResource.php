<?php

namespace Modules\Delivery\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class DeliveryResource extends ResourceCollection
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
            'message' => 'داده های مربوطه به روش های ارسال',
            'status' => 'success',
            'count' => count($this->collection),
            'data' => $this->collection->map(function ($order) {
                return [

                ];
            }),
        ];
    }
}
