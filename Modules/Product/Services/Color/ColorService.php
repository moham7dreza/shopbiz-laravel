<?php

namespace Modules\Product\Services\Color;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Modules\Product\Entities\Color;

class ColorService implements ColorServiceInterface
{

    /**
     * Store category.
     *
     * @param  $request
     * @return Builder|Model|RedirectResponse
     */
    public function store($request): Model|Builder|RedirectResponse
    {
        return $this->query()->create([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'color' => $request->color,
            'status' => $request->status,
        ]);
    }


    /**
     * @param $request
     * @param $color
     * @return mixed
     */
    public function update($request, $color): mixed
    {
        return $color->update([
            'name' => $request->name,
            'name_en' => $request->name_en,
            'color' => $request->color,
            'status' => $request->status,
        ]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Color::query();
    }
}
