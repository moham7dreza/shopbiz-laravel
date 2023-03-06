<?php

namespace Modules\Faq\Http\Controllers\Api;

use Modules\Faq\Http\Resources\FaqResource;
use Modules\Faq\Repositories\FaqRepoEloquentInterface;
use Modules\Faq\Services\FaqService;

class ApiFaqController
{
    public FaqRepoEloquentInterface $repo;
    public FaqService $service;

    /**
     * @param FaqRepoEloquentInterface $faqRepoEloquent
     * @param FaqService $faqService
     */
    public function __construct(FaqRepoEloquentInterface $faqRepoEloquent, FaqService $faqService)
    {
        $this->repo = $faqRepoEloquent;
        $this->service = $faqService;
    }

    /**
     * @return FaqResource
     */
    public function index(): FaqResource
    {
        $faqs = $this->repo->index()->get();
        return new FaqResource($faqs);
    }
}
