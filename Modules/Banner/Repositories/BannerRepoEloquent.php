<?php

namespace Modules\Banner\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Banner\Entities\Banner;

class BannerRepoEloquent implements BannerRepoEloquentInterface
{
    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('title', 'like', '%' . $name . '%')
            ->orWhere('position', $name)->latest();
    }

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
     * @return array|string[]
     */
    public function positions(): array
    {
        return Banner::$positions;
    }

    /**
     * Find role by id.
     *
     * @param  $id
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findById($id): Model|Collection|Builder|array|null
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Delete role by id.
     *
     * @param $id
     * @return mixed
     */
    public function delete($id): mixed
    {
        return $this->query()->where('id', $id)->delete();
    }

    /**
     * @param int $position
     * @return Builder
     */
    public function getBannerByPosition(int $position): Builder
    {
        return $this->query()->where('position', $position);
    }

    /**
     * @param int $position
     * @return Builder
     */
    public function getActiveBannerByPosition(int $position): Builder
    {
        return $this->query()->active()->where('position', $position)->latest();
    }

    /**
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Banner::query();
    }
}
