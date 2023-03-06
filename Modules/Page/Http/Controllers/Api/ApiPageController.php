<?php

namespace Modules\Page\Http\Controllers\Api;

use Modules\Page\Http\Resources\PageResource;
use Modules\Page\Repositories\PageRepoEloquentInterface;
use Modules\Page\Services\PageService;
use Modules\Share\Http\Controllers\Controller;

class ApiPageController extends Controller
{
    public PageRepoEloquentInterface $repo;
    public PageService $service;

    /**
     * @param PageRepoEloquentInterface $pageRepoEloquent
     * @param PageService $pageService
     */
    public function __construct(PageRepoEloquentInterface $pageRepoEloquent, PageService $pageService)
    {
        $this->repo = $pageRepoEloquent;
        $this->service = $pageService;
    }

    /**
     * @return PageResource
     */
    public function index(): PageResource
    {
        $pages = $this->repo->index()->paginate(10);
        return new PageResource($pages);
    }
}
