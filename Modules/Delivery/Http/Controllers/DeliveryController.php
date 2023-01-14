<?php

namespace Modules\Delivery\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Modules\Delivery\Entities\Delivery;
use Modules\Delivery\Http\Requests\DeliveryRequest;
use Modules\Delivery\Repositories\DeliveryRepoEloquentInterface;
use Modules\Delivery\Services\DeliveryService;
use Modules\Share\Http\Controllers\Controller;

class DeliveryController extends Controller
{
    /**
     * @var string
     */
    private string $redirectRoute = 'delivery.index';

    /**
     * @var string
     */
    private string $class = Delivery::class;

    public DeliveryRepoEloquentInterface $repo;
    public DeliveryService $service;

    /**
     * @param DeliveryRepoEloquentInterface $deliveryRepoEloquent
     * @param DeliveryService $deliveryService
     */
    public function __construct(DeliveryRepoEloquentInterface $deliveryRepoEloquent, DeliveryService $deliveryService)
    {
        $this->repo = $deliveryRepoEloquent;
        $this->service = $deliveryService;

        $this->middleware('can:permission-delivery-methods')->only(['index']);
        $this->middleware('can:permission-delivery-method-create')->only(['create', 'store']);
        $this->middleware('can:permission-delivery-method-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-delivery-method-delete')->only(['destroy']);
        $this->middleware('can:permission-delivery-method-status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $delivery_methods = $this->repo->index()->paginate(10);
        return view('Delivery::index', compact(['delivery_methods']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Delivery::create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DeliveryRequest $request
     * @return RedirectResponse
     */
    public function store(DeliveryRequest $request): RedirectResponse
    {
        $inputs = $request->all();
        $delivery = Delivery::query()->create($inputs);
        return redirect()->route('delivery.index')->with('swal-success', 'روش ارسال جدید شما با موفقیت ثبت شد');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(403);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Delivery $delivery
     * @return Application|Factory|View
     */
    public function edit(Delivery $delivery): View|Factory|Application
    {
        return view('Delivery::edit', compact(['delivery']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DeliveryRequest $request
     * @param Delivery $delivery
     * @return RedirectResponse
     */
    public function update(DeliveryRequest $request, Delivery $delivery): RedirectResponse
    {
        $inputs = $request->all();
        $delivery->update($inputs);
        return redirect()->route('delivery.index')->with('swal-success', 'روش ارسال شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Delivery $delivery
     * @return RedirectResponse
     */
    public function destroy(Delivery $delivery): RedirectResponse
    {
        $result = $delivery->delete();
        return redirect()->route('delivery.index')->with('swal-success', 'روش ارسال شما با موفقیت حذف شد');
    }


    /**
     * @param Delivery $delivery
     * @return JsonResponse
     */
    public function status(Delivery $delivery): JsonResponse
    {

        $delivery->status = $delivery->status == 0 ? 1 : 0;
        $result = $delivery->save();
        if ($result) {
            if ($delivery->status == 0) {
                return response()->json(['status' => true, 'checked' => false]);
            } else {
                return response()->json(['status' => true, 'checked' => true]);
            }
        } else {
            return response()->json(['status' => false]);
        }

    }

}
