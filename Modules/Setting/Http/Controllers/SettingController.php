<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Http\Requests\SettingRequest;
use Modules\Setting\Repositories\SettingRepoEloquentInterface;
use Modules\Setting\Services\SettingService;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class SettingController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @var string
     */
    private string $redirectRoute = 'setting.index';

    /**
     * @var string
     */
    private string $class = Setting::class;

    public SettingRepoEloquentInterface $repo;
    public SettingService $service;

    /**
     * @param SettingRepoEloquentInterface $settingRepoEloquent
     * @param SettingService $settingService
     */
    public function __construct(SettingRepoEloquentInterface $settingRepoEloquent, SettingService $settingService)
    {
        $this->repo = $settingRepoEloquent;
        $this->service = $settingService;

        $this->middleware('can:permission setting')->only(['index']);
        $this->middleware('can:permission setting edit')->only(['edit', 'update']);
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): Factory|View|Application
    {
        $setting = $this->service->seedNewSettingIfNotExists();
        return view('Setting::index', compact(['setting']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort(403);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(403);
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
     * @param Setting $setting
     * @return Application|Factory|View
     */
    public function edit(Setting $setting): View|Factory|Application
    {
        return view('Setting::edit', compact(['setting']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SettingRequest $request
     * @param Setting $setting
     * @return RedirectResponse
     */
    public function update(SettingRequest $request, Setting $setting): RedirectResponse
    {
        $result = $this->service->update($request, $setting);
        if ($result == 'logo upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود لوگو با خطا مواجه شد', 'خطا', status: 'error');
        } elseif ($result == 'icon upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود آیکون با خطا مواجه شد', 'خطا', status: 'error');
        }
        return $this->showMessageWithRedirectRoute('تنظیمات سایت شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(403);
    }
}
