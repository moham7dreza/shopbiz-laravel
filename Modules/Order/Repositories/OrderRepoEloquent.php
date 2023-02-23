<?php

namespace Modules\Order\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\Order;

class OrderRepoEloquent implements OrderRepoEloquentInterface
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
     * @param $orderType
     * @return Model|Builder|null
     */
    public function search($name, $orderType): Model|Builder|null
    {
        if ($orderType === 'newOrders') {

        }
        return $this->query()->where('name' , 'like', '%' . $name . '%')->latest();
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
     * user profile
     * @param $type
     * @return mixed
     */
    public function findUserOrdersByStatus($type): mixed
    {
        return auth()->user()->orders()->where('order_status', $type)->latest();
    }

    /**
     * @return Model|Builder|null
     */
    public function findUserUncheckedOrder(): Model|Builder|null
    {
        return $this->query()->where([
           ['user_id', auth()->id()],
           ['order_status', Order::ORDER_STATUS_NOT_CHECKED]
        ])->first();
    }

    /**
     * @return Model|Builder|null
     */
    public function findUserUncheckedOrderWithEmptyCopan(): Model|Builder|null
    {
        return $this->query()->where([
            ['user_id', auth()->id()],
            ['order_status', Order::ORDER_STATUS_NOT_CHECKED],
            ['copan_id', null]
        ])->first();
    }

    /**
     * @return Builder
     */
    public function newOrders(): Builder
    {
        return $this->query()->where('order_status', Order::ORDER_STATUS_NOT_CHECKED)->latest();
    }

    /**
     * @return Builder
     */
    public function sending(): Builder
    {
        return $this->query()->where('delivery_status', Order::DELIVERY_STATUS_SENDING)->latest();
    }

    /**
     * @return Builder
     */
    public function unpaid(): Builder
    {
        return $this->query()->where('payment_status', Order::PAYMENT_STATUS_NOT_PAID)->latest();
    }

    /**
     * @return Builder
     */
    public function canceled(): Builder
    {
        return $this->query()->where('order_status', Order::ORDER_STATUS_CANCELED)->latest();
    }

    /**
     * @return Builder
     */
    public function returned(): Builder
    {
        return $this->query()->where('order_status', Order::ORDER_STATUS_RETURNED)->latest();
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
     * panel
     * @return int
     */
    public function ordersCount(): int
    {
        return $this->query()->count();
    }

    /**
     * @return mixed
     */
    public function newOrdersCount(): mixed
    {
        return $this->query()->new()->count();
    }

    /**
     * panel
     * @return Builder|Model|null
     */
    public function getLastOrder(): Model|Builder|null
    {
        return $this->query()->orderBy('updated_at', 'desc')->first();
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
