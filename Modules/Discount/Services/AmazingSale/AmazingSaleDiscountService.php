<?php

namespace Modules\Discount\Services\AmazingSale;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Discount\Entities\AmazingSale;
use Modules\Share\Services\ShareService;

class AmazingSaleDiscountService
{
    /**
     * @param $request
     * @return Builder|Model
     */
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'product_id' => $request->product_id,
            'percentage' => $request->percentage,
            'start_date' => ShareService::realTimestampDateFormat($request->start_date),
            'end_date' => ShareService::realTimestampDateFormat($request->end_date),
            'status' => $request->status,
        ]);
    }

    /**
     * @param $request
     * @param $amazingSale
     * @return mixed
     */
    public function update($request, $amazingSale): mixed
    {
        return $amazingSale->update([
            'product_id' => $request->product_id,
            'percentage' => $request->percentage,
            'start_date' => ShareService::realTimestampDateFormat($request->start_date),
            'end_date' => ShareService::realTimestampDateFormat($request->end_date),
            'status' => $request->status,
        ]);
    }

//    /**
//     * Store discount & sync discount to products by array of data.
//     *
//     * @param array $data
//     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
//     */
//    public function store(array $data)
//    {
//        $discount = $this->query()->create([
//            'user_id' => auth()->id(),
//            'code' => $data['code'],
//            'percent' => $data['percent'],
//            'usage_limitation' => $data['usage_limitation'],
//            'expire_at' => $this->setExpiredAt($data["expire_at"]),
//            'link' => $data['link'],
//            'type' => $data['type'],
//            'description' => $data['description'],
//            'uses' => 0
//        ]);
//        $this->syncDiscountToProducts($discount, $data["products"]);
//
//        return $discount;
//    }
//
//    /**
//     * Update discount with sync to products by id & array of data.
//     *
//     * @param array $data
//     * @param int $id
//     * @return null
//     */
//    public function update(array $data, int $id)
//    {
//        $discount = resolve(DiscountRepoEloquentInterface::class)->findById($id);
//        $discount->update([
//            "code" => $data["code"],
//            "percent" => $data["percent"],
//            "usage_limitation" => $data["usage_limitation"],
//            "expire_at" => $this->setExpiredAt($data["expire_at"]),
//            "link" => $data["link"],
//            "type" => $data["type"],
//            "description" => $data["description"],
//        ]);
//
//        $this->syncDiscountToProducts($discount, $data["products"]);
//
//        return $discount;
//    }

    # Private methods

    /**
     * Get query for article model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return AmazingSale::query();
    }

//    /**
//     * Sync discount & products.
//     *
//     * @param  $discount
//     * @param  $products
//     * @return void
//     */
//    private function syncDiscountToProducts($discount, $products): void
//    {
//        $discount->type === DiscountTypeEnum::TYPE_SPECIAL->value
//            ? $discount->products()->sync($products)
//            : $discount->products()->sync([]);
//    }
//
//    /**
//     * Set expire_at.
//     *
//     * @param  $expire_at
//     * @return \Carbon\Carbon|null
//     */
//    private function setExpiredAt($expire_at)
//    {
//        return $expire_at ?: null;
//    }
}
