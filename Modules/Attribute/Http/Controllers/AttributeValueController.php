<?php

namespace Modules\Attribute\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Entities\AttributeValue;
use Modules\Attribute\Http\Requests\AttributeValueRequest;
use Modules\Attribute\Repositories\AttributeValue\AttributeValueRepoEloquentInterface;
use Modules\Attribute\Services\AttributeValue\AttributeValueServiceInterface;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Product\Repositories\Product\ProductRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class AttributeValueController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'attributeValue.index';

    /**
     * @var string
     */
    private string $class = AttributeValue::class;

    public AttributeValueRepoEloquentInterface $repo;
    public AttributeValueServiceInterface $service;

    /**
     * @param AttributeValueRepoEloquentInterface $repo
     * @param AttributeValueServiceInterface $service
     */
    public function __construct(AttributeValueRepoEloquentInterface $repo, AttributeValueServiceInterface $service)
    {
        $this->repo = $repo;
        $this->service = $service;

        $this->middleware('can:permission attribute values')->only(['index']);
        $this->middleware('can:permission attribute value create')->only(['create', 'store']);
        $this->middleware('can:permission attribute value edit')->only(['edit', 'update']);
        $this->middleware('can:permission attribute value delete')->only(['destroy']);
        $this->middleware('can:permission attribute value status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Attribute $attribute
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Attribute $attribute): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $values = $this->repo->search(request()->search);
            if (count($values) > 0) {
                $this->showToastOfFetchedRecordsCount(count($values));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } else {
            $values = $attribute->values()->paginate(10);
        }

        if ($attribute->categories()->count() > 0) {
            return view('Attribute::value.index', compact(['attribute', 'values']));
        }
        return $this->showMessageWithRedirectRoute(msg: 'برای ایجاد مقدار فرم کالا ابتدا باید دسته بندی تعریف کنید.', title: 'خطا', status: 'error', params: [$attribute->id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Attribute $attribute
     * @return Application|Factory|View|RedirectResponse
     */
    public function create(Attribute $attribute): View|Factory|Application|RedirectResponse
    {
        $productsCollection = $attribute->categories()->with('products')->get()->pluck('products');
        $products = collect();
        foreach ($productsCollection as $collection) {
            foreach ($collection as $product) {
                $products->push($product);
            }
        }
        if ($products->count() > 0) {
            return view('Attribute::value.create', compact(['attribute', 'products']));
        }
        return $this->showMessageWithRedirectRoute(msg: 'برای ایجاد مقدار فرم کالا ابتدا باید دسته بندی تعریف کنید.', title: 'خطا', status: 'error', params: [$attribute->id]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeValueRequest $request
     * @param Attribute $attribute
     * @param ProductRepoEloquentInterface $productRepo
     * @return RedirectResponse
     */
    public function store(AttributeValueRequest $request, Attribute $attribute, ProductRepoEloquentInterface $productRepo): RedirectResponse
    {
//        $request->category_id = $productRepo->findById($request->product_id)->category->id;
        $this->service->store($request, $attribute);
        return $this->showMessageWithRedirectRoute(msg: 'مقدار فرم کالای جدید شما با موفقیت ثبت شد', params: [$attribute->id]);
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
     * @param Attribute $attribute
     * @param AttributeValue $value
     * @return Application|Factory|View
     */
    public function edit(Attribute $attribute, AttributeValue $value): View|Factory|Application
    {
        $productsCollection = $attribute->categories()->with('products')->get()->pluck('products');
        $products = collect();
        foreach ($productsCollection as $collection) {
            foreach ($collection as $product) {
                $products->push($product);
            }
        }
        return view('Attribute::value.edit', compact(['attribute', 'value', 'products']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeValueRequest $request
     * @param Attribute $attribute
     * @param AttributeValue $value
     * @param ProductRepoEloquentInterface $productRepo
     * @return RedirectResponse
     */
    public function update(AttributeValueRequest $request, Attribute $attribute, AttributeValue $value, ProductRepoEloquentInterface $productRepo): RedirectResponse
    {
        $request->category_id = $productRepo->findById($request->product_id)->category->id;
        $this->service->update($request, $attribute, $value);
        return $this->showMessageWithRedirectRoute(msg: 'مقدار فرم کالای  شما با موفقیت ویرایش شد', params: [$attribute->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Attribute $attribute
     * @param AttributeValue $value
     * @return RedirectResponse
     */
    public function destroy(Attribute $attribute, AttributeValue $value): RedirectResponse
    {
        $result = $value->delete();
        return $this->showMessageWithRedirectRoute(msg: 'مقدار فرم کالای  شما با موفقیت حذف شد', params: [$attribute->id]);
    }
}
