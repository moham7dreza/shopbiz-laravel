<?php

namespace Modules\Post\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Comment\Services\CommentService;
use Modules\Post\Entities\Post;
use Modules\Post\Http\Requests\Home\AddCommentToPostRequest;
use Modules\Post\Repositories\PostRepoEloquentInterface;
use Modules\Post\Services\PostService;
use Modules\Product\Entities\Product;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class PostController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public PostRepoEloquentInterface $repo;
    public PostService $service;

    /**
     * @param PostRepoEloquentInterface $PostRepoEloquent
     * @param PostService $PostService
     */
    public function __construct(PostRepoEloquentInterface $PostRepoEloquent, PostService $PostService)
    {
        $this->repo = $PostRepoEloquent;
        $this->service = $PostService;
    }

    /**
     * @param Post $post
     * @return Application|Factory|View
     */
    public function post(Post $post): View|Factory|Application
    {
        views($post)->record();
        $relatedPosts = $this->repo->relatedItems($post)->get();
        return view('Post::home.post', compact(['post', 'relatedPosts']));
    }

    /**
     * @param Post $post
     * @param AddCommentToPostRequest $request
     * @param CommentService $commentService
     * @return RedirectResponse
     */
    public function addComment(Post $post, AddCommentToPostRequest $request, CommentService $commentService): RedirectResponse
    {
        if (!auth()->check()) {
            return $this->showAlertWithRedirect(message: 'برای ثبت نظر بایستی عضوی از وبسایت ما باشید.', title: 'خطا', type: 'error');
        }
        $commentService->store($request, $post);
        if (ShareService::checkForAdmin()) {
            return $this->showToastWithRedirect(title: 'نظر شما با موفقیت ثبت شد.');
            //            return back()->with('swal-timer', 'نظر شما با موفقیت ثبت شد.');
        }
//        return back()->with('swal-animate', 'نظر شما با موفقیت ثبت شد. پس از تایید در سایت قرار خواهد گرفت.');
        return $this->showAlertWithRedirect(message: 'نظر شما با موفقیت ثبت شد پس از تایید در سایت قرار خواهد گرفت.');
    }


    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function addToFavorite(Post $post): JsonResponse
    {
        return $this->service->postAddToFavorite($post);
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function like(Post $post): JsonResponse
    {
        return $this->service->productLike($post);
    }
}
