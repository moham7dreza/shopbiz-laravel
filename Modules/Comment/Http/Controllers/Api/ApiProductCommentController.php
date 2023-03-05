<?php

namespace Modules\Comment\Http\Controllers\Api;

use Modules\Comment\Http\Resources\ProductCommentResource;
use Modules\Comment\Repositories\CommentRepoEloquentInterface;
use Modules\Comment\Services\CommentService;
use Modules\Share\Http\Controllers\Controller;

class ApiProductCommentController extends Controller
{
    public CommentRepoEloquentInterface $repo;
    public CommentService $service;

    /**
     * @param CommentRepoEloquentInterface $postCommentRepoEloquent
     * @param CommentService $commentService
     */
    public function __construct(CommentRepoEloquentInterface $postCommentRepoEloquent, CommentService $commentService)
    {
        $this->repo = $postCommentRepoEloquent;
        $this->service = $commentService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ProductCommentResource
     */
    public function unSeenComments(): ProductCommentResource
    {
        $unSeenComments = $this->repo->getUnseenProductComments()->get();
        return new ProductCommentResource($unSeenComments);
    }

}
