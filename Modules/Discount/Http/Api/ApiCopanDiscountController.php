<?php

namespace Modules\Discount\Http\Api;

use Modules\Discount\Http\Resources\CopanDiscountResource;
use Modules\Discount\Repositories\Copan\CopanDiscountRepoEloquentInterface;
use Modules\Discount\Services\Copan\CopanDiscountService;
use Modules\Share\Http\Controllers\Controller;

class ApiCopanDiscountController extends Controller
{
    public CopanDiscountRepoEloquentInterface $repo;
    public CopanDiscountService $service;

    /**
     * @param CopanDiscountRepoEloquentInterface $repo
     * @param CopanDiscountService $service
     */
    public function __construct(CopanDiscountRepoEloquentInterface $repo, CopanDiscountService $service,)
    {
        $this->repo = $repo;
        $this->service = $service;
    }

    public function index()
    {
        $copans = $this->repo->getLatestOrderByDate()->get();
        return new CopanDiscountResource($copans);
    }
}
