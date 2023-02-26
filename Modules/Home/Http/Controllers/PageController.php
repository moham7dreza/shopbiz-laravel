<?php

namespace Modules\Home\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Faq\Repositories\FaqRepoEloquentInterface;
use Modules\Home\Http\Requests\ContactUsRequest;
use Modules\Home\Http\Requests\MeetRequest;
use Modules\Page\Repositories\PageRepoEloquentInterface;
use Modules\Setting\Repositories\SettingRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;

class PageController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public PageRepoEloquentInterface $pageRepo;

    /**
     * @param PageRepoEloquentInterface $pageRepo
     */
    public function __construct(PageRepoEloquentInterface $pageRepo)
    {
        $this->pageRepo = $pageRepo;
    }

    /**
     * @return Application|Factory|View
     */
    public function aboutUs(): View|Factory|Application
    {
        $page = $this->pageRepo->search('درباره ما')->active()->first();
        ShareService::setBasicSeoMetas('درباره ما', 'درباره ما', 'درباره ما');
        return view('Home::pages.about-us', compact(['page']));
    }

    /**
     * @param SettingRepoEloquentInterface $settingRepo
     * @return Application|Factory|View
     */
    public function contactUs(SettingRepoEloquentInterface $settingRepo): View|Factory|Application
    {
        $setting = $settingRepo->getSystemSetting();
        ShareService::setBasicSeoMetas('تماس با ما', 'تماس با ما', 'تماس با ما');
        return view('Home::pages.contact-us', compact(['setting']));
    }

    public function contactUsSubmit(ContactUsRequest $request)
    {

    }

    /**
     * @return Application|Factory|View
     */
    public function warrantyRules(): View|Factory|Application
    {
        $page = $this->pageRepo->search('شرایط گارانتی')->active()->first();
        ShareService::setBasicSeoMetas('شرایط گارانتی', 'شرایط گارانتی', 'شرایط گارانتی');
        return view('Home::pages.warranty-rules', compact(['page']));
    }

    /**
     * @param FaqRepoEloquentInterface $faqRepo
     * @return Application|Factory|View
     */
    public function faq(FaqRepoEloquentInterface $faqRepo): View|Factory|Application
    {
        $faqs = $faqRepo->index()->active()->get();
        ShareService::setBasicSeoMetas('سوالات متداول', 'سوالات متداول', 'سوالات متداول');
        return view('Home::pages.faq', compact(['faqs']));
    }

    /**
     * @return Application|Factory|View
     */
    public function installment(): View|Factory|Application
    {
        $page = $this->pageRepo->search('خرید اقساطی')->active()->first();
        ShareService::setBasicSeoMetas('خرید اقساطی', 'خرید اقساطی', 'خرید اقساطی');
        return view('Home::pages.installment', compact(['page']));
    }

    /**
     * @return Application|Factory|View
     */
    public function whyThisShop(): View|Factory|Application
    {
        $page = $this->pageRepo->search('چرا شاپ بیز')->active()->first();
        ShareService::setBasicSeoMetas('چرا شاپ بیز', 'چرا شاپ بیز', 'چرا شاپ بیز');
        return view('Home::pages.why-this-shop', compact(['page']));
    }

    /**
     * @return Application|Factory|View
     */
    public function howToBuy(): View|Factory|Application
    {
        $page = $this->pageRepo->search('راهنمای خرید')->active()->first();
        ShareService::setBasicSeoMetas('راهنمای خرید', 'راهنمای خرید', 'راهنمای خرید');
        return view('Home::pages.how-to-buy', compact(['page']));
    }

    /**
     * @return Application|Factory|View
     */
    public function price(): View|Factory|Application
    {
        ShareService::setBasicSeoMetas('پلن های قیمت گذاری ما', 'پلن های قیمت گذاری ما', 'پلن های قیمت گذاری ما');
        return view('Home::pages.price');
    }

    /**
     * @return Application|Factory|View
     */
    public function career(): View|Factory|Application
    {
        $page = $this->pageRepo->search('سابقه شغلی')->active()->first();
        ShareService::setBasicSeoMetas('سابقه شغلی', 'سابقه شغلی', 'سابقه شغلی');
        return view('Home::pages.career', compact(['page']));
    }

    /**
     * @return Application|Factory|View
     */
    public function privacyPolicy(): View|Factory|Application
    {
        $page = $this->pageRepo->search('شرایط و قوانین ما')->active()->first();
        ShareService::setBasicSeoMetas('شرایط و قوانین ما', 'شرایط و قوانین ما', 'شرایط و قوانین ما');
        return view('Home::pages.privacy-policy', compact(['page']));
    }

    /**
     * @return Factory|View|Application
     */
    public function makeAppointment(): Factory|View|Application
    {
        ShareService::setBasicSeoMetas('ثبت قرار ملاقات', 'ثبت قرار ملاقات', 'ثبت قرار ملاقات');
        return view('Home::pages.make-appointment');
    }

    public function meetSubmit(MeetRequest $request)
    {

    }
}
