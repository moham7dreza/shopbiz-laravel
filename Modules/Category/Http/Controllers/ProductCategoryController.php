<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Category\Entities\ProductCategory;
use Modules\Category\Http\Requests\ProductCategoryRequest;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Category\Services\ProductCategory\ProductCategoryServiceInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\Image\ImageService;

class ProductCategoryController extends Controller
{
    private string $redirectRoute = 'product-category.index';

    private string $class = ProductCategory::class;

    public ProductCategoryRepoEloquentInterface $categoryRepo;
    public ProductCategoryServiceInterface $categoryService;

    public function __construct(ProductCategoryRepoEloquentInterface $productCategoryRepo, ProductCategoryServiceInterface $productCategoryService)
    {
        $this->categoryRepo = $productCategoryRepo;
        $this->categoryService = $productCategoryService;

        $this->middleware('can:permission-product-categories')->only(['index']);
        $this->middleware('can:permission-product-category-create')->only(['create', 'store']);
        $this->middleware('can:permission-product-category-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-product-category-delete')->only(['destroy']);
        $this->middleware('can:permission-product-category-status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $productCategories = ProductCategory::query()->orderBy('created_at', 'desc')->simplePaginate(15);
        return view('Category::product-category.index', compact(['productCategories']));
    }


    /**
     * @return Application|Factory|View
     */
    public function create()
    {
        $categories = ProductCategory::query()->where('parent_id', null)->get();
        return view('Category::product-category.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductCategoryRequest $request
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function store(ProductCategoryRequest $request, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();
        if($request->hasFile('image'))
        {
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if($result === false)
            {
                return redirect()->route('product-category.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }

        $productCategory = ProductCategory::query()->create($inputs);
        return redirect()->route('product-category.index')->with('swal-success', 'دسته بندی جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
    public function edit(ProductCategory $productCategory)
    {
        $parent_categories = ProductCategory::query()->where('parent_id', null)->get()->except($productCategory->id);
        return view('Category::product-category.index', compact('productCategory', 'parent_categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductCategoryRequest $request
     * @param ProductCategory $productCategory
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();

        if($request->hasFile('image'))
        {
            if(!empty($productCategory->image))
            {
                $imageService->deleteDirectoryAndFiles($productCategory->image['directory']);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'product-category');
            $result = $imageService->createIndexAndSave($request->file('image'));
            if($result === false)
            {
                return redirect()->route('product-category.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['image'] = $result;
        }
        else{
            if(isset($inputs['currentImage']) && !empty($productCategory->image))
            {
                $image = $productCategory->image;
                $image['currentImage'] = $inputs['currentImage'];
                $inputs['image'] = $image;
            }
        }
        $productCategory->update($inputs);
        return redirect()->route('product-category.index')->with('swal-success', 'دسته بندی شما با موفقیت ویرایش شد');
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
       return redirect()->route('product-category.index')->with('swal-success', 'دسته بندی شما با موفقیت حذف شد');
    }
}
