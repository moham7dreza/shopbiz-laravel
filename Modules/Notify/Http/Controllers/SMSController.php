<?php

namespace Modules\Notify\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Notify\Entities\SMS;
use Modules\Notify\Http\Requests\SMSRequest;
use Modules\Notify\Repositories\SMS\SMSRepoEloquentInterface;
use Modules\Notify\Services\SMS\SMSService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\SuccessToastMessageWithRedirectTrait;

class SMSController extends Controller
{
    use SuccessToastMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'sms.index';

    /**
     * @var string
     */
    private string $class = SMS::class;

    public SMSRepoEloquentInterface $repo;
    public SMSService $service;

    /**
     * @param SMSRepoEloquentInterface $smsRepoEloquent
     * @param SMSService $smsService
     */
    public function __construct(SMSRepoEloquentInterface $smsRepoEloquent, SMSService $smsService)
    {
        $this->repo = $smsRepoEloquent;
        $this->service = $smsService;

        $this->middleware('can:permission-sms-notify')->only(['index']);
        $this->middleware('can:permission-sms-notify-create')->only(['create', 'store']);
        $this->middleware('can:permission-sms-notify-edit')->only(['edit', 'update']);
        $this->middleware('can:permission-sms-notify-delete')->only(['destroy']);
        $this->middleware('can:permission-sms-notify-status')->only(['status']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $sms = $this->repo->index()->paginate(10);
        return view('Notify::sms.index', compact(['sms']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('Notify::sms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SMSRequest $request
     * @return RedirectResponse
     */
    public function store(SMSRequest $request): RedirectResponse
    {
        $this->service->store($request);
        return $this->successMessageWithRedirect('پیامک شما با موفقیت ثبت شد');
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
     * @param SMS $sms
     * @return Application|Factory|View
     */
    public function edit(SMS $sms): View|Factory|Application
    {
        return view('Notify::sms.edit', compact(['sms']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SMSRequest $request
     * @param SMS $sms
     * @return RedirectResponse
     */
    public function update(SMSRequest $request, SMS $sms): RedirectResponse
    {
        $this->service->update($request, $sms);
        return $this->successMessageWithRedirect('پیامک شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SMS $sms
     * @return RedirectResponse
     */
    public function destroy(SMS $sms): RedirectResponse
    {
        $result = $sms->delete();
        return $this->successMessageWithRedirect('پیامک شما با موفقیت حذف شد');
    }


    /**
     * @param SMS $sms
     * @return JsonResponse
     */
    public function status(SMS $sms): JsonResponse
    {
        return ShareService::changeStatus($sms);
    }
}
