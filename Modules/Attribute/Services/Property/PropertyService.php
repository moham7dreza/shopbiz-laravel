<?php
namespace Modules\Attribute\Services\Property;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PropertyService implements PropertyServiceInterface
{

    /**
     * Store menu.
     *
     * @param  $request
     * @return Builder|Model
     */
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'name' => $request->name,
//            'type' => $request->type,
            'unit' => $request->unit,
            'category_id' => $request->category_id,
        ]);
    }

    /**
     * Update menu.
     *
     * @param  $request
     * @param $categoryAttribute
     * @return mixed
     */
    public function update($request, $categoryAttribute): mixed
    {
        return $categoryAttribute->update([
            'name' => $request->name,
//            'type' => $request->type,
            'unit' => $request->unit,
            'category_id' => $request->category_id,
        ]);
    }

    /**
     * Return category query.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return CategoryAttribute::query();
    }
}
