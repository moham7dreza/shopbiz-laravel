<?php

namespace Modules\Comment\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Comment\Entities\Comment;
use Modules\Comment\Http\Requests\CommentRequest;
use Modules\Comment\Repositories\CommentRepoEloquentInterface;
use Modules\Comment\Services\CommentService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class PostCommentController extends Controller
{
    use SuccessToastMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'postComment.index';

    /**
     * @var string
     */
    private string $class = Comment::class;

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

        $this->middleware('can:permission-post-comments')->only(['index']);
        $this->middleware('can:permission-post-comment-show')->only(['show']);
        $this->middleware('can:permission-post-comment-status')->only(['status']);
        $this->middleware('can:permission-post-comment-approve')->only(['approved']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $unSeenComments = $this->repo->getUnseenPostComments();
        $this->service->makeSeenComments($unSeenComments);
        $postComments = $this->repo->getLatestPostComments()->paginate(10);
        return view('Comment::post-comment.index', compact(['postComments']));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param Comment $postComment
     * @return Application|Factory|View
     */
    public function show(Comment $postComment): View|Factory|Application
    {
        return view('Comment::post-comment.show', compact(['postComment']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(403);
    }


    /**
     * @param Comment $postComment
     * @return JsonResponse
     */
    public function status(Comment $postComment): JsonResponse
    {
        return ShareService::changeStatus($postComment);
    }

    /**
     * @param Comment $postComment
     * @return RedirectResponse
     */
    public function approved(Comment $postComment): RedirectResponse
    {
        $result = $this->service->approveComment($postComment);
        if ($result) {
            return $this->successMessageWithRedirect('وضعیت نظر با موفقیت تغییر کرد');
        } else {
            return $this->successMessageWithRedirect('تایید نظر با خطا مواجه شد', 'swal-error');
        }
    }


    /**
     * @param CommentRequest $request
     * @param Comment $postComment
     * @return RedirectResponse
     */
    public function answer(CommentRequest $request, Comment $postComment): RedirectResponse
    {
        if ($postComment->parent == null) {
            $this->service->replyComment($request, $postComment);
            return $this->successMessageWithRedirect('پاسخ شما با موفقیت ثبت شد');
        } else {
            return $this->successMessageWithRedirect('خطا', 'swal-error');
        }
    }
}
