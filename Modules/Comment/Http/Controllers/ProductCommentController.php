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
use Modules\Share\Http\Controllers\Controller;

class ProductCommentController extends Controller
{
    private string $redirectRoute = 'productComment.index';

    private string $class = Comment::class;

    public CommentRepoEloquentInterface $repo;

    public function __construct(CommentRepoEloquentInterface $productCommentRepoEloquent)
    {
        $this->repo = $productCommentRepoEloquent;

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
        foreach ($unSeenComments as $unSeenComment) {
            $unSeenComment->seen = 1;
            $result = $unSeenComment->save();
        }
        $productComments = $this->repo->getLatestProductComments()->paginate(10);
        return view('Comment::product-comment.index', compact('productComments'));
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
        return view('Comment::product-comment.show', compact('productComment'));
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

        $productComment->status = $productComment->status == 0 ? 1 : 0;
        $result = $productComment->save();
        if ($result) {
            if ($productComment->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }

    /**
     * @param Comment $productComment
     * @return RedirectResponse
     */
    public function approved(Comment $productComment): RedirectResponse
    {

        $productComment->approved = $productComment->approved == 0 ? 1 : 0;
        $result = $productComment->save();
        if ($result) {
            return redirect()->route('productComment.index')->with('swal-success', '  وضعیت نظر با موفقیت تغییر کرد');
        } else {
            return redirect()->route('productComment.index')->with('swal-error', '  وضعیت نظر با خطا مواجه شد');
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
            $inputs = $request->all();
            $inputs['author_id'] = 1;
            $inputs['parent_id'] = $productComment->id;
            $inputs['commentable_id'] = $productComment->commentable_id;
            $inputs['commentable_type'] = $productComment->commentable_type;
            $inputs['approved'] = 1;
            $inputs['status'] = 1;
            $productComment = Comment::query()->create($inputs);
            return redirect()->route('productComment.index')->with('swal-success', '  پاسخ شما با موفقیت ثبت شد');
        } else {
            return redirect()->route('productComment.index')->with('swal-error', 'خطا');

        }
    }

}
