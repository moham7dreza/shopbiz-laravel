<?php

namespace Modules\Attribute\Services\PropertyValue;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PropertyValueService implements PropertyValueServiceInterface
{
    /**
     * Store menu.
     *
     * @param  $request
     * @param $categoryAttribute
     * @return Builder|Model
     */
    public function store($request, $categoryAttribute): Model|Builder
    {
        return $this->query()->create([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'category_attribute_id' => $categoryAttribute->id,
            'value' => json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]),
        ]);
    }

    /**
     * Update menu.
     *
     * @param  $request
     * @param $categoryAttribute
     * @param $value
     * @return mixed
     */
    public function update($request, $categoryAttribute, $value): mixed
    {
        return $value->update([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'category_attribute_id' => $categoryAttribute->id,
            'value' => json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]),
        ]);
    }

    /**
     * Return category query.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return CategoryValue::query();
    }
}
