<?php

namespace Modules\Setting\Http\Controllers\Api;

use Modules\Setting\Http\Resources\SettingResource;
use Modules\Setting\Repositories\SettingRepoEloquentInterface;
use Modules\Setting\Services\SettingService;

class ApiSettingController
{
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
    }

    /**
     * @return SettingResource
     */
    public function index(): SettingResource
    {
        $setting = $this->repo->getSystemSetting();
        return new SettingResource($setting);
    }
}
