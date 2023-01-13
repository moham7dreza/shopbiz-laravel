<?php

namespace Modules\Order\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\Order;

class OrderRepoEloquent implements OrderRepoEloquentInterface
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
    public function newOrders(): Builder
    {
        return $this->query()->where('order_status', 0)->latest();
    }

    /**
     * @return Builder
     */
    public function sending(): Builder
    {
        return $this->query()->where('delivery_status', 1)->latest();
    }

    /**
     * @return Builder
     */
    public function unpaid(): Builder
    {
        return $this->query()->where('payment_status', 0)->latest();
    }

    /**
     * @return Builder
     */
    public function canceled(): Builder
    {
        return $this->query()->where('order_status', 4)->latest();
    }

    /**
     * @return Builder
     */
    public function returned(): Builder
    {
        return $this->query()->where('order_status', 5)->latest();
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
        return Order::query();
    }
}
