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
use Modules\Share\Http\Services\Image\ImageService;

class PostCategoryController extends Controller
{
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
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $user = auth()->user();
        // if ($user->can('show-category')) {

        $postCategories = $this->categoryRepo->getLatestCategories()->paginate(10);
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
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function store(PostCategoryRequest $request, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();
        if ($request->hasFile('image')) {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            // $result = $imageService->save($request->file('image'));
            // $result = $imageService->fitAndSave($request->file('image'), 600, 150);
            // exit;
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('postCategory.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }

        $postCategory = PostCategory::query()->create($inputs);
        return redirect()->route('postCategory.index')->with('swal-success', 'دسته بندی جدید شما با موفقیت ثبت شد');
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
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function update(PostCategoryRequest $request, PostCategory $postCategory, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();

        if ($request->hasFile('image')) {
            if (!empty($postCategory->image)) {
                $imageService->deleteDirectoryAndFiles($postCategory->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'post-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if ($result === false) {
                return redirect()->route('postCategory.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        } else {
            if (isset($inputs['currentImage']) && !empty($postCategory->image)) {
                $image = $postCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        // $inputs['slug'] = null;
        $postCategory->update($inputs);
        return redirect()->route('postCategory.index')->with('swal-success', 'دسته بندی شما با موفقیت ویرایش شد');
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
        return redirect()->route('postCategory.index')->with('swal-success', 'دسته بندی شما با موفقیت حذف شد');
    }

    /**
     * @param PostCategory $postCategory
     * @return JsonResponse
     */
    public function status(PostCategory $postCategory): JsonResponse
    {
        $postCategory->status = $postCategory->status == 0 ? 1 : 0;
        $result = $postCategory->save();
        if ($result) {
            if ($postCategory->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }
}
