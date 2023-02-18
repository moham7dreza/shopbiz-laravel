<?php

namespace Modules\Product\Services\ProductColor;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Product\Entities\ProductColor;

class ProductColorService implements ProductColorServiceInterface
{

    /**
     * Store category.
     *
     * @param  $request
     * @param $productId
     * @return Builder|Model|RedirectResponse
     */
    public function store($request, $productId): Model|Builder|RedirectResponse
    {
        return $this->query()->create([
            'product_id' => $productId,
            'status' => $request->status,
            'color_id' => $request->color_id,
            'price_increase' => $request->price_increase,
            'sold_number' => $request->sold_number,
            'frozen_number' => $request->frozen_number,
            'marketable_number' => $request->marketable_number,
        ]);
    }


    /**
     * @param $request
     * @param $productId
     * @param $color
     * @return mixed
     */
    public function update($request, $productId, $color): mixed
    {
        return $color->update([
            'product_id' => $productId,
            'status' => $request->status,
            'color_id' => $request->color_id,
            'price_increase' => $request->price_increase,
            'sold_number' => $request->sold_number,
            'frozen_number' => $request->frozen_number,
            'marketable_number' => $request->marketable_number,
        ]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return ProductColor::query();
    }
}
