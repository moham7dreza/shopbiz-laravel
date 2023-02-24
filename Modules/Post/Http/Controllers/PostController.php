<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\ACL\Entities\Permission;
use Modules\Category\Repositories\PostCategory\PostCategoryRepoEloquentInterface;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Post\Entities\Post;
use Modules\Post\Http\Requests\PostRequest;
use Modules\Post\Repositories\PostRepoEloquentInterface;
use Modules\Post\Services\PostService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Tag\Repositories\TagRepositoryEloquentInterface;

class PostController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'post.index';

    /**
     * @var string
     */
    private string $class = Post::class;

    public PostRepoEloquentInterface $repo;
    public PostService $service;

    /**
     * @param PostRepoEloquentInterface $postRepoEloquent
     * @param PostService $postService
     */
    public function __construct(PostRepoEloquentInterface $postRepoEloquent, PostService $postService)
    {
        $this->repo = $postRepoEloquent;
        $this->service = $postService;

        $this->middleware('can:' . Permission::PERMISSION_POSTS)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_POST_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_POST_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_POST_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_POST_STATUS)->only(['status']);
        $this->middleware('can:' . Permission::PERMISSION_POST_COMMENTABLE)->only(['commentable']);
        $this->middleware('can:' . Permission::PERMISSION_POST_TAGS)->only(['setTags', 'tagsForm']);
    }

    // public function __construct()
    // {
    //     $this->authorizeResource(Post::class, 'post');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $posts = $this->repo->search(request()->search)->paginate(10);
            if (count($posts) > 0) {
                $this->showToastOfFetchedRecordsCount(count($posts));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $posts = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($posts) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $posts = $this->repo->index()->paginate(10);
        }
        return view('Post::index', compact(['posts']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param PostCategoryRepoEloquentInterface $postCategoryRepo
     * @return Application|Factory|View|RedirectResponse
     */
    public function create(PostCategoryRepoEloquentInterface $postCategoryRepo): View|Factory|Application|RedirectResponse
    {
        $postCategories = $postCategoryRepo->getLatestCategories()->get();
        if ($postCategories->count() > 0) {
            return view('Post::create', compact(['postCategories']));
        }
        return $this->showMessageWithRedirectRoute(msg: 'برای ایجاد پست ابتدا باید دسته بندی تعریف کنید.', title: 'خطا', status: 'error');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return RedirectResponse
     */
    public function store(PostRequest $request): RedirectResponse
    {
        // if($request->user()->cannot('create'))
        // {
        //     abort(403);
        // }

        // $this->authorize('create', Post::class);

        $result = $this->service->store($request);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('پست جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Post $post
     * @param PostCategoryRepoEloquentInterface $postCategoryRepo
     * @return Application|Factory|View
     */
    public function edit(Post $post, PostCategoryRepoEloquentInterface $postCategoryRepo): View|Factory|Application
    {
        $postCategories = $postCategoryRepo->getLatestCategories()->get();
        return view('Post::edit', compact(['post', 'postCategories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function update(PostRequest $request, Post $post): RedirectResponse
    {

        // if(!Gate::allows('update-post', $post))
        // {
        //     abort(403);
        // }

        // if($request->user()->can('update', $post))
        // {

        // }
//        if($request->user()->cannot('update', $post))
//        {
//            abort(403);
//        }

        // $this->authorize('update', $post);

        $result = $this->service->update($request, $post);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('پست شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        $result = $post->delete();
        return $this->showMessageWithRedirectRoute('پست شما با موفقیت حذف شد');
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function status(Post $post): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($post);
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function commentable(Post $post): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($post, 'commentable');
    }

    /**
     * @param Post $post
     * @param TagRepositoryEloquentInterface $tagRepositoryEloquent
     * @return Application|Factory|View
     */
    public function tagsForm(Post $post, TagRepositoryEloquentInterface $tagRepositoryEloquent): View|Factory|Application
    {
        $tags = $tagRepositoryEloquent->index()->get();
        return view('Post::tags-form', compact(['post', 'tags']));
    }

    /**
     * @param PostRequest $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function setTags(PostRequest $request, Post $post): RedirectResponse
    {
        $post->tags()->sync($request->tags);
        return $this->showMessageWithRedirectRoute('تگ های پست با موفقیت بروزرسانی شد');
    }
}
