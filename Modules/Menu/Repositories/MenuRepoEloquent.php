<?php

namespace Modules\Menu\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Menu\Entities\Menu;

class MenuRepoEloquent implements MenuRepoEloquentInterface
{
    /**
     * Get the latest roles with permissions.
     *
     * @return Builder
     */
    public function index(): Builder
    {
        return $this->query()->latest();
    }

    /**
     * @return Builder
     */
    public function getParentMenus(): Builder
    {
        return $this->query()->where('parent_id', null)->latest();
    }

    /**
     * Find role by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id)
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete role by id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    // home queries

    /**
     * @return Builder
     */
    public function getActiveParentMenus(): Builder
    {
        return $this->query()->where([
            ['parent_id', null],
            ['status', Menu::STATUS_ACTIVE],
        ])->latest();
    }

    /**
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Menu::query();
    }
}
