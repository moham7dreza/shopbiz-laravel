<?php

namespace Modules\Attribute\Services\AttributeValue;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Attribute\Entities\AttributeValue;

class AttributeValueService implements AttributeValueServiceInterface
{
    /**
     * Store menu.
     *
     * @param  $request
     * @param $attribute
     * @return Builder|Model
     */
    public function store($request, $attribute): Model|Builder
    {
        return $this->query()->create([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'selected' => $request->selected,
            'attribute_id' => $attribute->id,
            'value' => json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]),
//            'category_id' => $request->category_id,
        ]);
    }

    /**
     * Update menu.
     *
     * @param  $request
     * @param $attribute
     * @param $value
     * @return mixed
     */
    public function update($request, $attribute, $value): mixed
    {
        return $value->update([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'selected' => $request->selected,
            'attribute_id' => $attribute->id,
            'value' => json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]),
//            'category_id' => $request->category_id,
        ]);
    }

    /**
     * Return category query.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return AttributeValue::query();
    }
}
