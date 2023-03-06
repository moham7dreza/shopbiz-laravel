<?php

namespace Modules\Delivery\Http\Controllers\Api;

use Modules\Delivery\Http\Resources\DeliveryResource;
use Modules\Delivery\Repositories\DeliveryRepoEloquentInterface;
use Modules\Delivery\Services\DeliveryService;
use Modules\Share\Http\Controllers\Controller;

class ApiDeliveryController extends Controller
{
    public DeliveryRepoEloquentInterface $repo;
    public DeliveryService $service;

    /**
     * @param DeliveryRepoEloquentInterface $deliveryRepoEloquent
     * @param DeliveryService $deliveryService
     */
    public function __construct(DeliveryRepoEloquentInterface $deliveryRepoEloquent, DeliveryService $deliveryService)
    {
        $this->repo = $deliveryRepoEloquent;
        $this->service = $deliveryService;
    }

    /**
     * @return DeliveryResource
     */
    public function index(): DeliveryResource
    {
        $methods = $this->repo->index()->get();
        return new DeliveryResource($methods);
    }
}
