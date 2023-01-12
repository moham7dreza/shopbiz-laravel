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

class PostCommentController extends Controller
{
    private string $redirectRoute = 'postComment.index';

    private string $class = Comment::class;

    public CommentRepoEloquentInterface $repo;

    public function __construct(CommentRepoEloquentInterface $postCommentRepoEloquent)
    {
        $this->repo = $postCommentRepoEloquent;

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
    public function index()
    {
        $unSeenComments = Comment::query()->where('commentable_type', 'Modules\Post\Entities\Post\Post')->where('seen', 0)->get();
        foreach ($unSeenComments as $unSeenComment){
            $unSeenComment->seen = 1;
            $result = $unSeenComment->save();
        }
        $postComments = Comment::query()->orderBy('created_at', 'desc')->where('commentable_type', 'Modules\Post\Entities\Post\Post')->simplePaginate(15);
        return view('Comment::post-comment.index', compact('comments'));

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
     * @param  \Illuminate\Http\Request  $request
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
    public function show(Comment $postComment)
    {
        return view('Comment::post-comment.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort(403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
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

        $postComment->status = $postComment->status == 0 ? 1 : 0;
        $result = $postComment->save();
        if($result){
                if($postComment->status == 0){
                    return response()->json(['status' => true, 'checked' => false]);
                }
                else{
                    return response()->json(['status' => true, 'checked' => true]);
                }
        }
        else{
            return response()->json(['status' => false]);
        }

    }

    /**
     * @param Comment $postComment
     * @return RedirectResponse
     */
    public function approved(Comment $postComment){

        $postComment->approved = $postComment->approved == 0 ? 1 : 0;
        $result = $postComment->save();
        if($result){
            return redirect()->route('postComment.index')->with('swal-success', '  وضعیت نظر با موفقیت تغییر کرد');
        }
        else{
            return redirect()->route('postComment.index')->with('swal-error', '  وضعیت نظر با خطا مواجه شد');
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
            $inputs = $request->all();
            $inputs['author_id'] = 1;
            $inputs['parent_id'] = $postComment->id;
            $inputs['commentable_id'] = $postComment->commentable_id;
            $inputs['commentable_type'] = $postComment->commentable_type;
            $inputs['approved'] = 1;
            $inputs['status'] = 1;
            $postComment = Comment::query()->create($inputs);
            return redirect()->route('postComment.index')->with('swal-success', '  پاسخ شما با موفقیت ثبت شد');
        }
        else{
            return redirect()->route('postComment.index')->with('swal-error', 'خطا');

        }
    }
}
