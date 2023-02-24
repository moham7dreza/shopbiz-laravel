<?php

namespace Modules\Comment\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
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

        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_COMMENTS)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_COMMENT_SHOW)->only(['show']);
        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_COMMENT_STATUS)->only(['status']);
        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_COMMENT_APPROVE)->only(['approved']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        $unSeenComments = $this->repo->getUnseenProductComments();
        $this->service->makeSeenComments($unSeenComments);
        if (isset(request()->search)) {
            $productComments = $this->repo->search(request()->search)->paginate(10);
            if (count($productComments) > 0) {
                $this->showToastOfFetchedRecordsCount(count($productComments));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $productComments = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($productComments) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $productComments = $this->repo->getLatestProductComments()->paginate(10);
        }
        $redirectRoute = $this->redirectRoute;
        return view('Comment::product-comment.index', compact(['productComments', 'redirectRoute']));
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
            return $this->showMessageWithRedirectRoute('وضعیت نظر با موفقیت تغییر کرد');
        } else {
            return $this->showMessageWithRedirectRoute('تایید نظر با خطا مواجه شد', 'خطا', status: 'error');
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
            $this->increaseCommentsCount($productComment);
            return $this->showMessageWithRedirectRoute('پاسخ شما با موفقیت ثبت شد');
        } else {
            return $this->showMessageWithRedirectRoute('با خطا مواجه شد', 'خطا', status: 'error');
        }
    }

    /**
     * @param $comment
     * @return void
     */
    private function increaseCommentsCount($comment): void
    {
        $model = $comment->commentable;
        $model->comments_count += 1;
        $model->save();
    }
}
