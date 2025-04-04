<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\ACL\Entities\Permission;
use Modules\Category\Entities\ProductCategory;
use Modules\Category\Http\Requests\ProductCategoryRequest;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Category\Services\ProductCategory\ProductCategoryServiceInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\Tag\Repositories\TagRepositoryEloquentInterface;

class ProductCategoryController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'productCategory.index';

    /**
     * @var string
     */
    private string $class = ProductCategory::class;

    public ProductCategoryRepoEloquentInterface $categoryRepo;
    public ProductCategoryServiceInterface $categoryService;

    /**
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @param ProductCategoryServiceInterface $productCategoryService
     */
    public function __construct(ProductCategoryRepoEloquentInterface $productCategoryRepo, ProductCategoryServiceInterface $productCategoryService)
    {
        $this->categoryRepo = $productCategoryRepo;
        $this->categoryService = $productCategoryService;

        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_CATEGORIES)->only(['index']);
        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_CATEGORY_CREATE)->only(['create', 'store']);
        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_CATEGORY_EDIT)->only(['edit', 'update']);
        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_CATEGORY_DELETE)->only(['destroy']);
        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_CATEGORY_STATUS)->only(['status']);
        $this->middleware('can:'. Permission::PERMISSION_PRODUCT_CATEGORY_SHOW_IN_MENU)->only(['showInMenu']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): View|Factory|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $productCategories = $this->categoryRepo->search(request()->search)->paginate(10);
            if (count($productCategories) > 0) {
                $this->showToastOfFetchedRecordsCount(count($productCategories));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $productCategories = $this->categoryRepo->sort(request()->sort, request()->dir)->paginate(10);
            if (count($productCategories) > 0) {
                $this->showToastOfSelectedDirection(request()->dir);
            }
            else { $this->showToastOfNotDataExists(); }
        } else {
            $productCategories = $this->categoryRepo->getLatestCategories()->paginate(10);
        }
        $redirectRoute = $this->redirectRoute;
        return view('Category::product-category.index', compact(['productCategories', 'redirectRoute']));
    }


    /**
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $categories = $this->categoryRepo->getParentCategories()->get();
        return view('Category::product-category.create', compact(['categories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(ProductCategoryRequest $request): RedirectResponse
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
     * @param ProductCategory $productCategory
     * @return Application|Factory|View
     */
    public function edit(ProductCategory $productCategory): View|Factory|Application
    {
        $parent_categories = $this->categoryRepo->getParentCategories()->get()->except($productCategory->id);
        return view('Category::product-category.edit', compact(['productCategory', 'parent_categories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductCategoryRequest $request
     * @param ProductCategory $productCategory
     * @return RedirectResponse
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        $result = $this->categoryService->update($request, $productCategory);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود تصویر با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('دسته بندی شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProductCategory $productCategory
     * @return RedirectResponse
     */
    public function destroy(ProductCategory $productCategory): RedirectResponse
    {
        $result = $productCategory->delete();
        return $this->showMessageWithRedirectRoute('دسته بندی شما با موفقیت حذف شد');
    }

    /**
     * @param ProductCategory $productCategory
     * @return JsonResponse
     */
    public function status(ProductCategory $productCategory): JsonResponse
    {
        return ShareService::changeStatus($productCategory);
    }

    /**
     * @param ProductCategory $productCategory
     * @return JsonResponse
     */
    public function showInMenu(ProductCategory $productCategory): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($productCategory, 'show_in_menu');
    }

    /**
     * @param ProductCategory $productCategory
     * @param TagRepositoryEloquentInterface $tagRepositoryEloquent
     * @return Application|Factory|View
     */
    public function tagsForm(ProductCategory $productCategory, TagRepositoryEloquentInterface $tagRepositoryEloquent): View|Factory|Application
    {
        $tags = $tagRepositoryEloquent->index()->get();
        return view('Category::product-category.tags-form', compact(['productCategory', 'tags']));
    }

    /**
     * @param ProductCategoryRequest $request
     * @param ProductCategory $productCategory
     * @return RedirectResponse
     */
    public function setTags(ProductCategoryRequest $request, ProductCategory $productCategory): RedirectResponse
    {
        $productCategory->tags()->sync($request->tags);
        return $this->showMessageWithRedirectRoute('تگ های دسته بندی با موفقیت بروزرسانی شد');
    }
}
