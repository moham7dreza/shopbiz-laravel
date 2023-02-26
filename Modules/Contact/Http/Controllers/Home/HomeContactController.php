<?php

namespace Modules\Contact\Http\Controllers\Home;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Contact\Http\Requests\ContactRequest;
use Modules\Contact\Services\ContactService;
use Modules\Setting\Repositories\SettingRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Services\StoreFileService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Repositories\UserRepoEloquentInterface;

class HomeContactController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public ContactService $service;
    public UserRepoEloquentInterface $userRepo;
    public StoreFileService $storeFileService;

    public function __construct(ContactService $service, UserRepoEloquentInterface $userRepo, StoreFileService $storeFileService)
    {
        $this->service = $service;
        $this->userRepo = $userRepo;
        $this->storeFileService = $storeFileService;
    }

    /**
     * @param SettingRepoEloquentInterface $settingRepo
     * @return Application|Factory|View
     */
    public function contactUs(SettingRepoEloquentInterface $settingRepo): View|Factory|Application
    {
        $setting = $settingRepo->getSystemSetting();
        ShareService::setBasicSeoMetas('تماس با ما', 'تماس با ما', 'تماس با ما');
        return view('Contact::home.pages.contact-us', compact(['setting']));
    }

    /**
     * @param ContactRequest $request
     * @return RedirectResponse
     */
    public function contactUsSubmit(ContactRequest $request): RedirectResponse
    {
        $contact = $this->service->store($request, 'contact');
        $result = $this->storeFileService->store($request, $contact);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود فایل با خطا مواجه شد', 'خطا', status: 'error');
        }
        $adminUser = $this->userRepo->findSystemAdmin();
        $this->service->sendContactCreatedNotificationToAdmin($adminUser, $contact->id, 'contact');
        return $this->showAlertWithRedirect('پیام شما با موفقیت ثبت شد');
    }

    /**
     * @return Factory|View|Application
     */
    public function makeAppointment(): Factory|View|Application
    {
        ShareService::setBasicSeoMetas('ثبت قرار ملاقات', 'ثبت قرار ملاقات', 'ثبت قرار ملاقات');
        return view('Contact::home.pages.make-appointment');
    }

    /**
     * @param ContactRequest $request
     * @return RedirectResponse
     */
    public function meetSubmit(ContactRequest $request): RedirectResponse
    {
        $contact = $this->service->store($request);
        $result = $this->storeFileService->store($request, $contact);
        if ($result == 'upload failed') {
            return $this->showMessageWithRedirectRoute('آپلود فایل با خطا مواجه شد', 'خطا', status: 'error');
        }
        $adminUser = $this->userRepo->findSystemAdmin();
        $this->service->sendContactCreatedNotificationToAdmin($adminUser, $contact->id);
        return $this->showAlertWithRedirect('فرم شما با موفقیت ثبت شد');
    }
}
