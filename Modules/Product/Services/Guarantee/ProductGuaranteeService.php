<?php

namespace Modules\Product\Services\Guarantee;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Product\Entities\Guarantee;

class ProductGuaranteeService implements ProductGuaranteeServiceInterface
{
    /**
     * Store guarantee.
     *
     * @param  $request
     * @param $productId
     * @return Builder|Model|RedirectResponse
     */
    public function store($request, $productId): Model|Builder|RedirectResponse
    {
        return $this->query()->create([
            'name' => $request->name,
            'duration' => $request->duration,
            'product_id' => $productId,
            'status' => $request->status,
            'price_increase' => $request->price_increase,
        ]);
    }

    /**
     * @param $request
     * @param $productId
     * @param $guarantee
     * @return mixed
     */
    public function update($request, $productId, $guarantee): mixed
    {
        return $guarantee->update([
            'name' => $request->name,
            'duration' => $request->duration,
            'product_id' => $productId,
            'status' => $request->status,
            'price_increase' => $request->price_increase,
        ]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Guarantee::query();
    }
}
