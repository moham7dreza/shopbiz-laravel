<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Category\Entities\ProductCategory;
use Modules\Category\Http\Requests\ProductCategoryRequest;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Category\Services\ProductCategory\ProductCategoryServiceInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

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

        $this->middleware('can:permission product categories')->only(['index']);
        $this->middleware('can:permission product category create')->only(['create', 'store']);
        $this->middleware('can:permission product category edit')->only(['edit', 'update']);
        $this->middleware('can:permission product category delete')->only(['destroy']);
        $this->middleware('can:permission product category status')->only(['status']);
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
        } else {
            $productCategories = $this->categoryRepo->getLatestCategories()->paginate(10);
        }

        return view('Category::product-category.index', compact(['productCategories']));
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
}
