<?php

namespace Modules\Product\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductResource extends ResourceCollection
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
            'message' => 'داده های مربوطه به کالاهای فروشگاه',
            'status' => 'success',
            'count' => count($this->collection),
            'data' => $this->collection->map(function ($product) {
                return [
                    'product_name' => $product->name,
                    'product_intro' => strip_tags($product->introduction),
                    'product_url' => $product->path(),
                    'product_price' => priceFormat($product->price),
                    'product_image' => asset($product->image['indexArray']['small']),
                    'product_sold_number' => $product->sold_number,
                    'product_marketable_number' => $product->marketable_number,
                    'product_category_name' => $product->category->name,
                    'product_brand_name' => $product->brand->persian_name,
//                    'product_active_amazing_sale_percentage' => $product->activeAmazingSales,
                    'product_created_date' => jalaliDate($product->created_at),
                    'product_updated_date' => jalaliDate($product->updated_at),
                ];
            }),
        ];
    }
}

