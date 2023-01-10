<?php

namespace Modules\Category\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Category\Entities\CategoryAttribute;
use Modules\Category\Entities\ProductCategory;
use Modules\Category\Http\Requests\CategoryAttributeRequest;
use Modules\Category\Repositories\Property\PropertyRepoEloquentInterface;
use Modules\Category\Services\Property\PropertyServiceInterface;
use Modules\Share\Http\Controllers\Controller;

class PropertyController extends Controller
{
    private string $redirectRoute = 'property.index';

    private string $class = CategoryAttribute::class;

    public PropertyRepoEloquentInterface $propertyRepo;
    public PropertyServiceInterface $propertyService;

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
    public function index()
    {
        $category_attributes = CategoryAttribute::all();
        return view('Category::property.index', compact('category_attributes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $productCategories = ProductCategory::all();
        return view('Category::property.create', compact('productCategories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryAttributeRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryAttributeRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $attribute = CategoryAttribute::query()->create($inputs);
        return redirect()->route('category-property.index')->with('swal-success', 'فرم جدید شما با موفقیت ثبت شد');
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
     * @param CategoryAttribute $category_property
     * @return Application|Factory|View
     */
    public function edit(CategoryAttribute $category_property)
    {
        $productCategories = ProductCategory::all();
        return view('Category::property.edit', compact('category_property', 'productCategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryAttributeRequest $request
     * @param CategoryAttribute $category_property
     * @return RedirectResponse
     */
    public function update(CategoryAttributeRequest $request, CategoryAttribute $category_property): RedirectResponse
    {
        $inputs = $request->all();
        $category_property->update($inputs);
        return redirect()->route('category-property.index')->with('swal-success', 'فرم شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategoryAttribute $category_property
     * @return RedirectResponse
     */
    public function destroy(CategoryAttribute $category_property): RedirectResponse
    {
        $result = $category_property->delete();
        return redirect()->route('category-property.index')->with('swal-success', 'فرم شما با موفقیت حذف شد');
    }
}
