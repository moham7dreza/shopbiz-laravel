<?php

namespace Modules\Attribute\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\ACL\Entities\Permission;
use Modules\Attribute\Entities\Attribute;
use Modules\Attribute\Http\Requests\AttributeRequest;
use Modules\Attribute\Repositories\Attribute\AttributeRepoEloquentInterface;
use Modules\Attribute\Services\Attribute\AttributeServiceInterface;
use Modules\Category\Repositories\ProductCategory\ProductCategoryRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class AttributeController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'attribute.index';

    /**
     * @var string
     */
    private string $class = Attribute::class;

    public AttributeRepoEloquentInterface $repo;
    public AttributeServiceInterface $service;

    /**
     * @param AttributeRepoEloquentInterface $attributeRepo
     * @param AttributeServiceInterface $attributeService
     */
    public function __construct(AttributeRepoEloquentInterface $attributeRepo, AttributeServiceInterface $attributeService)
    {
        $this->repo = $attributeRepo;
        $this->service = $attributeService;

        $this->middleware('can:' . Permission::PERMISSION_ATTRIBUTES)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_ATTRIBUTE_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_ATTRIBUTE_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_ATTRIBUTE_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_ATTRIBUTE_STATUS)->only(['status']);
        $this->middleware('can:' . Permission::PERMISSION_ATTRIBUTE_CATEGORIES)->only(['categoryForm', 'categoryUpdate']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $attributes = $this->repo->search(request()->search)->paginate(10);
            if (count($attributes) > 0) {
                $this->showToastOfFetchedRecordsCount(count($attributes));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $attributes = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            $this->showToastOfSelectedDirection(request()->dir);
        } else {
            $attributes = $this->repo->index()->paginate(10);
        }
        $redirectRoute = $this->redirectRoute;
        return view('Attribute::attribute.index', compact(['attributes', 'redirectRoute']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Attribute::attribute.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AttributeRequest $request
     * @return RedirectResponse
     */
    public function store(AttributeRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->showMessageWithRedirectRoute('فرم جدید شما با موفقیت ثبت شد');
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
     * @return Application|Factory|View
     */
    public function edit(Attribute $attribute): View|Factory|Application
    {
        return view('Attribute::attribute.edit', compact(['attribute']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function update(AttributeRequest $request, Attribute $attribute): RedirectResponse
    {
        $this->service->update($request, $attribute);
        return $this->showMessageWithRedirectRoute('فرم شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function destroy(Attribute $attribute): RedirectResponse
    {
        $result = $attribute->delete();
        return $this->showMessageWithRedirectRoute('فرم شما با موفقیت حذف شد');
    }

    /**
     * @param Attribute $attribute
     * @param ProductCategoryRepoEloquentInterface $productCategoryRepo
     * @return Application|Factory|View|RedirectResponse
     */
    public function categoryForm(Attribute $attribute, ProductCategoryRepoEloquentInterface $productCategoryRepo): View|Factory|Application|RedirectResponse
    {
        $categories = $productCategoryRepo->getLatestCategories()->get();
        if ($categories->count() > 0) {
            return view('Attribute::attribute.set-categories', compact(['attribute', 'categories']));
        }
        return $this->showMessageWithRedirectRoute(msg: 'برای تخصیص فرم کالا ابتدا باید دسته بندی تعریف کنید.', title: 'خطا', status: 'error');
    }

    /**
     * @param AttributeRequest $request
     * @param Attribute $attribute
     * @return RedirectResponse
     */
    public function categoryUpdate(AttributeRequest $request, Attribute $attribute): RedirectResponse
    {
        $attribute->categories()->sync($request->categories);
        return $this->showMessageWithRedirectRoute('دسته بندی های فرم کالا با موفقیت بروز رسانی شد');
    }

    /**
     * @param Attribute $attribute
     * @return JsonResponse
     */
    public function status(Attribute $attribute): JsonResponse
    {
        return ShareService::changeStatus($attribute);
    }
}
