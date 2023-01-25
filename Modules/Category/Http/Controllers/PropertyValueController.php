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
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class PropertyValueController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'CategoryValue.index';

    /**
     * @var string
     */
    private string $class = CategoryValue::class;

    public PropertyValueRepoEloquentInterface $propertyValueRepo;
    public PropertyValueServiceInterface $propertyValueService;

    /**
     * @param PropertyValueRepoEloquentInterface $propertyValueRepo
     * @param PropertyValueServiceInterface $propertyValueService
     */
    public function __construct(PropertyValueRepoEloquentInterface $propertyValueRepo, PropertyValueServiceInterface $propertyValueService)
    {
        $this->propertyValueRepo = $propertyValueRepo;
        $this->propertyValueService = $propertyValueService;

        $this->middleware('can:permission-product-property-values')->only(['index']);
        $this->middleware('can:permission-product-property-value-create')->only(['create', 'store']);
        $this->middleware('can:permission-product-property-value-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-product-property-value-delete')->only(['destroy']);
        $this->middleware('can:permission-product-property-value-status')->only(['status']);


    }

    /**
     * Display a listing of the resource.
     *
     * @param CategoryAttribute $categoryAttribute
     * @return Application|Factory|View
     */
    public function index(CategoryAttribute $categoryAttribute): Factory|View|Application
    {
        $values = $categoryAttribute->values()->paginate(10);
        return view('Category::property.value.index', compact(['categoryAttribute', 'values']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param CategoryAttribute $categoryAttribute
     * @return Application|Factory|View
     */
    public function create(CategoryAttribute $categoryAttribute): View|Factory|Application
    {
        return view('Category::property.value.create', compact(['categoryAttribute']));
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
        $this->propertyValueService->store($request, $categoryAttribute);
        return $this->showMessageWithRedirect(title: 'مقدار فرم کالای جدید شما با موفقیت ثبت شد', params: [$categoryAttribute->id]);
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
    public function edit(CategoryAttribute $categoryAttribute, CategoryValue $value): View|Factory|Application
    {
        return view('Category::property.value.edit', compact(['categoryAttribute', 'value']));
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
        $this->propertyValueService->update($request, $categoryAttribute, $value);
        return $this->showMessageWithRedirect(title:'مقدار فرم کالای  شما با موفقیت ویرایش شد', params: [$categoryAttribute->id]);
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
        return $this->showMessageWithRedirect(title:'مقدار فرم کالای  شما با موفقیت حذف شد', params: [$categoryAttribute->id]);
    }
}
