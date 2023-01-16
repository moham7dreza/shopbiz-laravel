<?php

namespace Modules\Delivery\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Delivery\Entities\Delivery;

class DeliveryService
{
    /**
     * Store delivery.
     *
     * @param  $request
     * @return Builder|Model
     */
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'name' => $request->name,
            'amount' => $request->amount,
            'delivery_time' => $request->delivery_time,
            'delivery_time_unit' => $request->delivery_time_unit,
            'status' => $request->status,
        ]);
    }

    /**
     * Update delivery.
     *
     * @param  $request
     * @param $delivery
     * @return mixed
     */
    public function update($request, $delivery): mixed
    {
        return $delivery->update([
            'name' => $request->name,
            'amount' => $request->amount,
            'delivery_time' => $request->delivery_time,
            'delivery_time_unit' => $request->delivery_time_unit,
            'status' => $request->status,
        ]);
    }

    /**
     * Get query for model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Delivery::query();
    }
}
