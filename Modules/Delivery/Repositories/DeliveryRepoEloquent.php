<?php

namespace Modules\Delivery\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Delivery\Entities\Delivery;

class DeliveryRepoEloquent implements DeliveryRepoEloquentInterface
{
    /**
     * @param $property
     * @param $dir
     * @return Builder
     */
    public function sort($property, $dir): Builder
    {
        return $this->query()->orderBy($property, $dir);
    }

    /**
     * @param $name
     * @return Model|Builder|null
     */
    public function search($name): Model|Builder|null
    {
        return $this->query()->where('name', 'like', '%' . $name . '%')->latest();
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
     * Find delivery method by id.
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
    public function delete($id)
    {
        return $this->query()->where('id', $id)->delete();
    }

    // home queries

    /**
     * @return Builder
     */
    public function activeMethods(): Builder
    {
        return $this->query()->where('status', Delivery::STATUS_ACTIVE);
    }

    /**
     * Builder for queue model.
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Delivery::query();
    }
}
