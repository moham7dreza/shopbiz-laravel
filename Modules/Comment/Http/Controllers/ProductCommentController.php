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
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ProductCommentController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'productComment.index';

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

        $this->middleware('can:permission-product-comments')->only(['index']);
        $this->middleware('can:permission-product-comment-show')->only(['show']);
        $this->middleware('can:permission-product-comment-status')->only(['status']);
        $this->middleware('can:permission-product-comment-approve')->only(['approved']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $unSeenComments = $this->repo->getUnseenProductComments();
        $this->service->makeSeenComments($unSeenComments);
        $productComments = $this->repo->getLatestProductComments()->paginate(10);
        return view('Comment::product-comment.index', compact(['productComments']));
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
     * @param Comment $productComment
     * @return Application|Factory|View
     */
    public function show(Comment $productComment): View|Factory|Application
    {
        return view('Comment::product-comment.show', compact(['productComment']));
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
     * @param Comment $productComment
     * @return JsonResponse
     */
    public function status(Comment $productComment): JsonResponse
    {
        return ShareService::changeStatus($productComment);
    }

    /**
     * @param Comment $productComment
     * @return RedirectResponse
     */
    public function approved(Comment $productComment): RedirectResponse
    {
        $result = $this->service->approveComment($productComment);
        if ($result) {
            return $this->showMessageWithRedirect('وضعیت نظر با موفقیت تغییر کرد');
        } else {
            return $this->showMessageWithRedirect('تایید نظر با خطا مواجه شد', 'swal-error');
        }
    }


    /**
     * @param CommentRequest $request
     * @param Comment $productComment
     * @return RedirectResponse
     */
    public function answer(CommentRequest $request, Comment $productComment): RedirectResponse
    {
        if ($productComment->parent == null) {
            $this->service->replyComment($request, $productComment);
            return $this->showMessageWithRedirect('پاسخ شما با موفقیت ثبت شد');
        } else {
            return $this->showMessageWithRedirect('خطا', 'swal-error');
        }
    }
}
