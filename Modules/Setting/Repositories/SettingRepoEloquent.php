<?php

namespace Modules\Setting\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Setting\Entities\Setting;

class SettingRepoEloquent implements SettingRepoEloquentInterface
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
     * @return Model|Builder|null
     */
    public function getSystemSetting(): Model|Builder|null
    {
        return $this->query()->first();
    }


    /**
     * @return mixed
     */
    public function findSystemLogo(): mixed
    {
        return $this->getSystemSetting()->pluck('logo')->first();
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

    /**
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Setting::query();
    }
}
