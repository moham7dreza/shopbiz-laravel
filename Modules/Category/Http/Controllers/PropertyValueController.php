<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Category\Entities\CategoryAttribute;
use Modules\Category\Entities\CategoryValue;
use Modules\Category\Http\Requests\CategoryValueRequest;
use Modules\Category\Repositories\PropertyValue\PropertyValueRepoEloquentInterface;
use Modules\Category\Services\PropertyValue\PropertyValueServiceInterface;
use Modules\Share\Http\Controllers\Controller;

class PropertyValueController extends Controller
{
    private string $redirectRoute = 'property-value.index';

    private string $class = CategoryValue::class;

    public PropertyValueRepoEloquentInterface $propertyValueRepo;
    public PropertyValueServiceInterface $propertyValueService;

    public function __construct(PropertyValueRepoEloquentInterface $propertyValueRepo, PropertyValueServiceInterface $propertyValueService)
    {
        $this->propertyValueRepo = $propertyValueRepo;
        $this->propertyValueService = $propertyValueService;

    }
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(CategoryAttribute $categoryAttribute)
    {
        return view('Category::property.value.index', compact('categoryAttribute'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(CategoryAttribute $categoryAttribute)
    {
        return view('Category::property.value.create', compact('categoryAttribute'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryValueRequest $request
     * @param CategoryAttribute $categoryAttribute
     * @return RedirectResponse
     */
    public function store(CategoryValueRequest $request ,CategoryAttribute $categoryAttribute): RedirectResponse
    {
        $inputs = $request->all();
        $inputs['value'] = json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]);
        $inputs['category_attribute_id'] = $categoryAttribute->id;
        $value = CategoryValue::query()->create($inputs);
        return redirect()->route('property-value.index', $categoryAttribute->id)->with('swal-success', 'مقدار فرم کالای جدید شما با موفقیت ثبت شد');
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
     * @param CategoryAttribute $categoryAttribute
     * @param CategoryValue $value
     * @return Application|Factory|View
     */
    public function edit(CategoryAttribute $categoryAttribute, CategoryValue $value)
    {
        return view('Category::property.value.edit', compact('categoryAttribute', 'value'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryValueRequest $request
     * @param CategoryAttribute $categoryAttribute
     * @param CategoryValue $value
     * @return RedirectResponse
     */
    public function update(CategoryValueRequest $request ,CategoryAttribute $categoryAttribute, CategoryValue $value): RedirectResponse
    {
        $inputs = $request->all();
        $inputs['value'] = json_encode(['value' => $request->value, 'price_increase' => $request->price_increase]);
        $inputs['category_attribute_id'] = $categoryAttribute->id;
        $value->update($inputs);
        return redirect()->route('property-value.index', $categoryAttribute->id)->with('swal-success', 'مقدار فرم کالای  شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CategoryAttribute $categoryAttribute
     * @param CategoryValue $value
     * @return RedirectResponse
     */
    public function destroy(CategoryAttribute $categoryAttribute, CategoryValue $value): RedirectResponse
    {
        $result = $value->delete();
        return redirect()->route('property-value.index', $categoryAttribute->id)->with('swal-success', 'مقدار فرم کالای  شما با موفقیت حذف شد');
    }
}
