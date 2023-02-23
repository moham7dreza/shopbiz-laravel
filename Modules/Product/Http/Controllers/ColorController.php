<?php

namespace Modules\Product\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\ACL\Entities\Permission;
use Modules\Product\Entities\Color;
use Modules\Product\Http\Requests\ColorRequest;
use Modules\Product\Repositories\Color\ColorRepoEloquentInterface;
use Modules\Product\Services\Color\ColorService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class ColorController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'color.index';

    /**
     * @var string
     */
    private string $class = Color::class;

    public ColorRepoEloquentInterface $repo;
    public ColorService $service;

    /**
     * @param ColorRepoEloquentInterface $colorRepoEloquent
     * @param ColorService $colorService
     */
    public function __construct(ColorRepoEloquentInterface $colorRepoEloquent, ColorService $colorService)
    {
        $this->repo = $colorRepoEloquent;
        $this->service = $colorService;

        $this->middleware('can:' . Permission::PERMISSION_COLORS)->only(['index']);
        $this->middleware('can:' . Permission::PERMISSION_COLOR_CREATE)->only(['create', 'store']);
        $this->middleware('can:' . Permission::PERMISSION_COLOR_EDIT)->only(['edit', 'update']);
        $this->middleware('can:' . Permission::PERMISSION_COLOR_DELETE)->only(['destroy']);
        $this->middleware('can:' . Permission::PERMISSION_COLOR_STATUS)->only(['status']);
    }

    /**
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(): Factory|View|Application|RedirectResponse
    {
        if (isset(request()->search)) {
            $colors = $this->repo->search(request()->search)->paginate(10);
            if (count($colors) > 0) {
                $this->showToastOfFetchedRecordsCount(count($colors));
            } else {
                return $this->showAlertOfNotResultFound();
            }
        } elseif (isset(request()->sort)) {
            $colors = $this->repo->sort(request()->sort, request()->dir)->paginate(10);
            $this->showToastOfSelectedDirection(request()->dir);
        } else {
            $colors = $this->repo->getLatest()->paginate(10);
        }

        return view('Product::admin.color.index', compact(['colors']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Product::admin.color.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ColorRequest $request
     * @return RedirectResponse
     */
    public function store(ColorRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->showMessageWithRedirectRoute('رنگ شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Color $color
     * @return Application|Factory|View
     */
    public function edit(Color $color): Application|Factory|View
    {
        return view('Product::admin.color.edit', compact(['color']));
    }


    /**
     * @param ColorRequest $request
     * @param Color $color
     * @return RedirectResponse
     */
    public function update(ColorRequest $request, Color $color): RedirectResponse
    {
        $this->service->update($request,$color);
        return $this->showMessageWithRedirectRoute('رنگ شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Color $color
     * @return RedirectResponse
     */
    public function destroy(Color $color): RedirectResponse
    {
        $color->delete();
        return $this->showMessageWithRedirectRoute('رنگ شما با موفقیت حذف شد');
    }

    /**
     * @param Color $color
     * @return JsonResponse
     */
    public function status(Color $color): JsonResponse
    {
        return ShareService::ajaxChangeModelSpecialField($color);
    }
}
