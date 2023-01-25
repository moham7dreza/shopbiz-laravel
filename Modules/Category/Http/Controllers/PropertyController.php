<?php

namespace Modules\Category\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Category\Entities\CategoryAttribute;
use Modules\Category\Http\Requests\CategoryAttributeRequest;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Category\Repositories\Property\PropertyRepoEloquentInterface;
use Modules\Category\Services\Property\PropertyServiceInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class PropertyController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'categoryAttribute.index';

    /**
     * @var string
     */
    private string $class = CategoryAttribute::class;

    public PropertyRepoEloquentInterface $propertyRepo;
    public PropertyServiceInterface $propertyService;

    /**
     * @param PropertyRepoEloquentInterface $propertyRepo
     * @param PropertyServiceInterface $propertyService
     */
    public function __construct(PropertyRepoEloquentInterface $propertyRepo, PropertyServiceInterface $propertyService)
    {
        $this->propertyRepo = $propertyRepo;
        $this->propertyService = $propertyService;

        $this->middleware('can:permission-product-properties')->only(['index']);
        $this->middleware('can:permission-product-property-create')->only(['create', 'store']);
        $this->middleware('can:permission-product-property-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-product-property-delete')->only(['destroy']);
        $this->middleware('can:permission-product-property-status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $categoryAttributes = $this->propertyRepo->index()->paginate(10);
        return view('Category::property.index', compact(['categoryAttributes']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @return Application|Factory|View
     */
    public function create(ProductCategoryRepoEloquentInterface $productCategoryRepo): View|Factory|Application
    {
        $productCategories = $productCategoryRepo->getLatestCategories()->get();
        return view('Category::property.create', compact(['productCategories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryAttributeRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryAttributeRequest $request): RedirectResponse
    {
        $this->propertyService->store($request);
        return $this->showMessageWithRedirect('فرم جدید شما با موفقیت ثبت شد');
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
     * @param CategoryAttribute $categoryAttribute
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @return Application|Factory|View
     */
    public function edit(CategoryAttribute $categoryAttribute, ProductCategoryRepoEloquentInterface $productCategoryRepo): View|Factory|Application
    {
        $productCategories = $productCategoryRepo->getLatestCategories()->get();
        return view('Category::property.edit', compact(['categoryAttribute', 'productCategories']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryAttributeRequest $request
     * @param CategoryAttribute $categoryAttribute
     * @return RedirectResponse
     */
    public function update(CategoryAttributeRequest $request, CategoryAttribute $categoryAttribute): RedirectResponse
    {
        $this->propertyService->update($request, $categoryAttribute);
        return $this->showMessageWithRedirect('فرم شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategoryAttribute $categoryAttribute
     * @return RedirectResponse
     */
    public function destroy(CategoryAttribute $categoryAttribute): RedirectResponse
    {
        $result = $categoryAttribute->delete();
        return $this->showMessageWithRedirect('فرم شما با موفقیت حذف شد');
    }
}
