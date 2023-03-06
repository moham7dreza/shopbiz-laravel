<?php

namespace Modules\Banner\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BannerResource extends ResourceCollection
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
            'message' => 'داده های مربوطه به بنرهای تبلیغاتی',
            'status' => 'success',
            'count' => count($this->collection),
            'data' => $this->collection->map(function ($order) {
                return [

                ];
            }),
        ];
    }
}
