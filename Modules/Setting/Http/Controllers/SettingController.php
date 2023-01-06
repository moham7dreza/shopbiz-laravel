<?php

namespace Modules\Setting\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Setting\Database\Seeders\SettingSeeder;
use Modules\Setting\Entities\Setting;
use Modules\Setting\Http\Requests\SettingRequest;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Http\Services\Image\ImageService;

class SettingController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $setting = Setting::query()->first();
        if($setting === null){
            $default = new SettingSeeder();
            $default->run();
            $setting = Setting::query()->first();
        }
        return view('Setting::index', compact('setting'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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
    public function edit(Setting $setting)
    {
        return view('Setting::edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SettingRequest $request
     * @param Setting $setting
     * @param ImageService $imageService
     * @return RedirectResponse
     */
    public function update(SettingRequest $request, Setting $setting, ImageService $imageService): RedirectResponse
    {
        $inputs = $request->all();

        if($request->hasFile('logo'))
        {
            if(!empty($setting->logo))
            {
                $imageService->deleteImage($setting->logo);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('logo');
            $result = $imageService->save($request->file('logo'));
            if($result === false)
            {
                return redirect()->route('setting.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['logo'] = $result;
        }
        if($request->hasFile('icon'))
        {
            if(!empty($setting->icon))
            {
                $imageService->deleteImage($setting->icon);
            }
            $imageService->setExclusiveDirectory('images' . DIRECTORY_SEPARATOR . 'setting');
            $imageService->setImageName('icon');
            $result = $imageService->save($request->file('icon'));
            if($result === false)
            {
                return redirect()->route('setting.index')->with('swal-error', 'آپلود تصویر با خطا مواجه شد');
            }
            $inputs['icon'] = $result;
        }
        $setting->update($inputs);
        return redirect()->route('setting.index')->with('swal-success', 'تنظیمات سایت  شما با موفقیت ویرایش شد');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(403);
    }
}
