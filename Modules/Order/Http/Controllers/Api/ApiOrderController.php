<?php

namespace Modules\Order\Http\Controllers\Api;

use Modules\Order\Http\Resources\OrderResource;
use Modules\Order\Repositories\OrderRepoEloquentInterface;
use Modules\Order\Services\OrderService;
use Modules\Share\Http\Controllers\Controller;

class ApiOrderController extends Controller
{
    public OrderRepoEloquentInterface $repo;
    public OrderService $service;

    /**
     * @param OrderRepoEloquentInterface $orderRepoEloquent
     * @param OrderService $orderService
     */
    public function __construct(OrderRepoEloquentInterface $orderRepoEloquent, OrderService $orderService)
    {
        $this->repo = $orderRepoEloquent;
        $this->service = $orderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return OrderResource
     */
    public function index(): OrderResource
    {
        $orders = $this->repo->index()->get();
        return new OrderResource($orders);
    }

    /**
     * @return OrderResource
     */
    public function newOrders(): OrderResource
    {
        $orders = $this->repo->newOrders()->get();
        return new OrderResource($orders);
    }
}
