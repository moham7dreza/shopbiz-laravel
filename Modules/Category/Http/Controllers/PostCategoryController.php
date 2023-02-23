<?php

namespace Modules\Category\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\ACL\Entities\Permission;
use Modules\Category\Entities\PostCategory;
use Modules\Category\Http\Requests\PostCategoryRequest;
use Modules\Category\Repositories\PostCategory\PostCategoryRepoEloquentInterface;
use Modules\Category\Services\PostCategory\PostCategoryServiceInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Tag\Repositories\TagRepositoryEloquentInterface;

class PostCategoryController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'postCategory.index';

    /**
     * @var string
     */
    private string $class = PostCategory::class;

    public PostCategoryRepoEloquentInterface $categoryRepo;
    public PostCategoryServiceInterface $categoryService;

    /**
     * @param PostCategoryRepoEloquentInterface $postCategoryRepo
     * @param PostCategoryServiceInterface $postCategoryService
     */
    public function __construct(PostCategoryRepoEloquentInterface $postCategoryRepo, PostCategoryServiceInterface $postCategoryService)
    {
        $this->categoryRepo = $postCategoryRepo;
        $this->categoryService = $postCategoryService;
//        $this->authorizeResource(PostCategory::class, 'post');
        $this->middleware('can:'. Permission::PERMISSION_POST_CATEGORIES)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_POST_CATEGORY_CREATE)->only(['create', 'store']);
        $this->middleware('can:'. Permission::PERMISSION_POST_CATEGORY_EDIT)->only(['edit', 'update']);
        $this->middleware('can:'. Permission::PERMISSION_POST_CATEGORY_DELETE)->only(['destroy']);
        $this->middleware('can:'. Permission::PERMISSION_POST_CATEGORY_STATUS)->only(['status']);
    }

//    function __construct()
//    {
    // $this->middleware('role:operator')->only(['edit']);
    // $this->middleware('role:operator')->only(['create']);
    // $this->middleware('role:accounting')->only(['store']);
    // $this->middleware('role:operator')->only(['edit']);
//        $this->middleware('can:show-category')->only(['index']);
//        $this->middleware('can:update-category')->only(['edit', 'update']);
//    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $postCategories = $this->categoryRepo->search(request()->search)->paginate(10);
            if (count($postCategories) > 0) {
                $this->showToastOfFetchedRecordsCount(count($postCategories));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $postCategories = $this->categoryRepo->sort(request()->sort, request()->dir)->paginate(10);
            $this->showToastOfSelectedDirection(request()->dir);
        } else {
            $postCategories = $this->categoryRepo->getLatestCategories()->paginate(10);
        }
//        $user = auth()->user();
        // if ($user->can('show-category')) {


        return view('Category::post-category.index', compact(['postCategories']));
        // } else {
        //     abort(403);
        // }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        // $imageCache = new ImageCacheService();
        // return $imageCache->cache('1.png');
        return view('Category::post-category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(PostCategoryRequest $request): RedirectResponse
    {
        $result = $this->categoryService->store($request);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('دسته بندی جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param PostCategory $postCategory
     * @return Application|Factory|View
     */
    public function edit(PostCategory $postCategory): View|Factory|Application
    {
        return view('Category::post-category.edit', compact(['postCategory']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostCategoryRequest $request
     * @param PostCategory $postCategory
     * @return RedirectResponse
     */
    public function update(PostCategoryRequest $request, PostCategory $postCategory): RedirectResponse
    {
        $result = $this->categoryService->update($request, $postCategory);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('دسته بندی شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param PostCategory $postCategory
     * @return RedirectResponse
     */
    public function destroy(PostCategory $postCategory): RedirectResponse
    {
        $result = $postCategory->delete();
        return $this->showMessageWithRedirectRoute('دسته بندی شما با موفقیت حذف شد');
    }

    /**
     * @param PostCategory $postCategory
     * @return JsonResponse
     */
    public function status(PostCategory $postCategory): JsonResponse
    {
        return ShareService::changeStatus($postCategory);
    }

    /**
     * @param PostCategory $postCategory
     * @param TagRepositoryEloquentInterface $tagRepositoryEloquent
     * @return Application|Factory|View
     */
    public function tagsForm(PostCategory $postCategory, TagRepositoryEloquentInterface $tagRepositoryEloquent): View|Factory|Application
    {
        $tags = $tagRepositoryEloquent->index()->get();
        return view('Category::post-category.tags-form', compact(['postCategory', 'tags']));
    }

    /**
     * @param PostCategoryRequest $request
     * @param PostCategory $postCategory
     * @return RedirectResponse
     */
    public function setTags(PostCategoryRequest $request, PostCategory $postCategory): RedirectResponse
    {
        $postCategory->tags()->sync($request->tags);
        return $this->showMessageWithRedirectRoute('تگ های دسته بندی با موفقیت بروزرسانی شد');
    }
}
