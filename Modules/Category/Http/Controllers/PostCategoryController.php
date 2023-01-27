<?php

namespace Modules\Category\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Category\Entities\PostCategory;
use Modules\Category\Http\Requests\PostCategoryRequest;
use Modules\Category\Repositories\PostCategory\PostCategoryRepoEloquentInterface;
use Modules\Category\Services\PostCategory\PostCategoryServiceInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

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
        $this->middleware('can:permission-post-categories')->only(['index']);
        $this->middleware('can:permission-post-categories-create')->only(['create', 'store']);
        $this->middleware('can:permission-post-categories-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-post-categories-delete')->only(['destroy']);
        $this->middleware('can:permission-post-categories-status')->only(['status']);
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
        $this->categoryService->store($request);
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
        $this->categoryService->update($request, $postCategory);
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
}
