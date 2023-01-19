<?php

namespace Modules\Post\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Post\Entities\Post;
use Modules\Post\Http\Requests\PostRequest;
use Modules\Post\Repositories\PostRepoEloquentInterface;
use Modules\Post\Services\PostService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\Image\ImageService;
use Modules\Share\Services\ShareService;

class PostController extends Controller
{

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

        $this->middleware('can:permission-posts')->only(['index']);
        $this->middleware('can:permission-post-create')->only(['create', 'store']);
        $this->middleware('can:permission-post-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-post-delete')->only(['destroy']);
        $this->middleware('can:permission-post-status')->only(['status']);
        $this->middleware('can:permission-post-status')->only(['status']);
        $this->middleware('can:permission-post-set-tags')->only(['setTags']);
        $this->middleware('can:permission-post-update-tags')->only(['updateTags']);
    }

    // public function __construct()
    // {
    //     $this->authorizeResource(Post::class, 'post');
    // }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $posts = $this->repo->index()->paginate(10);
        return view('Post::index', compact(['posts']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @return Application|Factory|View
     */
    public function create(ProductCategoryRepoEloquentInterface $productCategoryRepo): View|Factory|Application
    {
        $postCategories = $productCategoryRepo->getLatestCategories()->get();
        return view('Post::create', compact(['postCategories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function store(PostRequest $request, ImageService $imageService): RedirectResponse
    {
        // if($request->user()->cannot('create'))
        // {
        //     abort(403);
        // }

        // $this->authorize('create', Post::class);


        $inputs = $request->all();

        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('post.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }
        $inputs['author_id'] = auth()->user()->id;
        $post = Post::query()->create($inputs);
        return redirect()->route('post.index')->with('swal-success', 'پست  جدید شما با موفقیت ثبت شد');
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
     * @return Application|Factory|View
     */
    public function edit(Post $post, ProductCategoryRepoEloquentInterface $productCategoryRepo): View|Factory|Application
    {
        $postCategories = $productCategoryRepo->getLatestCategories()->get();
        return view('Post::edit', compact(['post', 'postCategories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostRequest $request
     * @param Post $post
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function update(PostRequest $request, Post $post, ImageService $imageService): RedirectResponse
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

        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0, 10);
        $inputs['published_at'] = date("Y-m-d H:i:s", (int)$realTimestampStart);

        if ($request->hasFile('image')) {
            if (!empty($post->image)) {
                $imageService->deleteDirectoryAndFiles($post->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('post.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($post->image)) {
                $image = $post->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $post->update($inputs);
        return redirect()->route('post.index')->with('swal-success', 'پست  شما با موفقیت ویرایش شد');
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
        return redirect()->route('post.index')->with('swal-success', 'پست  شما با موفقیت حذف شد');
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function status(Post $post): JsonResponse
    {
        return ShareService::changeStatus($post);
    }

    /**
     * @param Post $post
     * @return JsonResponse
     */
    public function commentable(Post $post): JsonResponse
    {
        $post->commentable = $post->commentable == 0 ? 1 : 0;
        $result = $post->save();
        if ($result) {
            if ($post->commentable == 0) {
                return response()->json(['commentable' => true, 'checked' => false]);
            } else {
                return response()->json(['commentable' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['commentable' => false]);
        }
    }
}
