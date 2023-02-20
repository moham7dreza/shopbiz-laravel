<?php
namespace Modules\Attribute\Services\Attribute;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Attribute\Entities\Attribute;

class AttributeService implements AttributeServiceInterface
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
            'name_en' => $request->name_en,
            'type' => $request->type,
            'unit' => $request->unit,
            'unit_en' => $request->unit_en,
            'status' => $request->status
        ]);
    }

    /**
     * Update menu.
     *
     * @param  $request
     * @param $attribute
     * @return mixed
     */
    public function update($request, $attribute): mixed
    {
        return $attribute->update([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'type' => $request->type,
            'unit' => $request->unit,
            'unit_en' => $request->unit_en,
            'status' => $request->status
        ]);
    }

    /**
     * Return category query.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Attribute::query();
    }
}
