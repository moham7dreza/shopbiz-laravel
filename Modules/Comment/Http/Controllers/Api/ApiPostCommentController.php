<?php

namespace Modules\Comment\Http\Controllers\Api;

use Modules\Comment\Http\Resources\PostCommentResource;
use Modules\Comment\Http\Resources\ProductCommentResource;
use Modules\Comment\Repositories\CommentRepoEloquentInterface;
use Modules\Comment\Services\CommentService;
use Modules\Share\Http\Controllers\Controller;

class ApiPostCommentController extends Controller
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
     * @return PostCommentResource
     */
    public function unSeenComments(): PostCommentResource
    {
        $unSeenComments = $this->repo->getUnseenPostComments()->get();
        return new PostCommentResource($unSeenComments);
    }

    /**
     * Display a listing of the resource.
     *
     * @return PostCommentResource
     */
    public function comments(): PostCommentResource
    {
        $comments = $this->repo->getLatestPostComments()->get();
        return new PostCommentResource($comments);
    }
}
