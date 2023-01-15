<?php

namespace Modules\Menu\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Menu\Entities\Menu;

class MenuService
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
            'url' => $request->url,
            'status' => $request->status,
            'parent_id' => $request->parent_id,
        ]);
    }

    /**
     * Update menu.
     *
     * @param  $request
     * @param $menu
     * @return mixed
     */
    public function update($request, $menu): mixed
    {
        return $menu->update([
            'name' => $request->name,
            'url' => $request->url,
            'status' => $request->status,
            'parent_id' => $request->parent_id,
        ]);
    }

    /**
     * Get query for model (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Menu::query();
    }
}
