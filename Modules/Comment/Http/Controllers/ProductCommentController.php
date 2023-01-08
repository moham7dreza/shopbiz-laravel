<?php

namespace Modules\Comment\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Comment\Entities\Comment;
use Modules\Comment\Http\Requests\CommentRequest;
use Modules\Share\Http\Controllers\Controller;

class ProductCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $unSeenComments = Comment::query()->where('commentable_type', 'Modules\Product\Entities\Product')->where('seen', 0)->get();
        foreach ($unSeenComments as $unSeenComment) {
            $unSeenComment->seen = 1;
            $result = $unSeenComment->save();
        }
        $comments = Comment::query()->orderBy('created_at', 'desc')->where('commentable_type', 'Modules\Product\Entities\Product')->simplePaginate(15);
        return view('Comment::product-comment.index', compact('comments'));
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
     * @param Comment $comment
     * @return Application|Factory|View
     */
    public function show(Comment $comment)
    {
        return view('Comment::product-comment.show', compact('comment'));
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
     * @param Comment $comment
     * @return JsonResponse
     */
    public function status(Comment $comment): JsonResponse
    {

        $comment->status = $comment->status == 0 ? 1 : 0;
        $result = $comment->save();
        if ($result) {
            if ($comment->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }

    /**
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function approved(Comment $comment): RedirectResponse
    {

        $comment->approved = $comment->approved == 0 ? 1 : 0;
        $result = $comment->save();
        if ($result) {
            return redirect()->route('product-comment.index')->with('swal-success', '  وضعیت نظر با موفقیت تغییر کرد');
        } else {
            return redirect()->route('product-comment.index')->with('swal-error', '  وضعیت نظر با خطا مواجه شد');
        }

    }


    /**
     * @param CommentRequest $request
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function answer(CommentRequest $request, Comment $comment)
    {
        if ($comment->parent == null) {
            $inputs = $request->all();
            $inputs['author_id'] = 1;
            $inputs['parent_id'] = $comment->id;
            $inputs['commentable_id'] = $comment->commentable_id;
            $inputs['commentable_type'] = $comment->commentable_type;
            $inputs['approved'] = 1;
            $inputs['status'] = 1;
            $comment = Comment::query()->create($inputs);
            return redirect()->route('product-comment.index')->with('swal-success', '  پاسخ شما با موفقیت ثبت شد');
        } else {
            return redirect()->route('product-comment.index')->with('swal-error', 'خطا');

        }
    }

}
