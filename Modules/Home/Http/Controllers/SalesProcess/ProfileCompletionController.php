<?php

namespace Modules\Home\Http\Controllers\SalesProcess;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Home\Http\Requests\SalesProcess\ProfileCompletionRequest;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Services\UserService;

class ProfileCompletionController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public CartRepoEloquentInterface $cartRepo;
    public UserService $userService;

    public function __construct(CartRepoEloquentInterface $cartRepo, UserService $userService)
    {
        $this->cartRepo = $cartRepo;
        $this->userService = $userService;
    }

    /**
     * @return Factory|View|Application
     */
    public function profileCompletion(): Factory|View|Application
    {
        SEOTools::setTitle('تکمیل اطلاعات حساب کاربری');
        SEOTools::setDescription('تکمیل اطلاعات حساب کاربری');

        $cartItems = $this->cartRepo->findUserCartItems()->get();
        return view('Home::sales-process.profile-completion',compact(['cartItems']));

    }

    /**
     * @param ProfileCompletionRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileCompletionRequest $request): RedirectResponse
    {
        $result = $this->userService->profileCompletion($request);
        if ($result === 'mobile invalid') {
            return $this->showAlertWithRedirect(message: 'فرمت شماره موبایل معتبر نیست', title: 'خطا', type: 'error');
        }
        return $this->showToastWithRedirect(title: 'اطلاعات شما تکمیل و ثبت شد.', route: 'customer.sales-process.address-and-delivery');
//        return to_route('customer.sales-process.address-and-delivery');
    }
}
