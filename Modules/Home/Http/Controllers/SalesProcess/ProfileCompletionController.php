<?php

namespace Modules\Home\Http\Controllers\SalesProcess;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Cart\Repositories\CartRepoEloquentInterface;
use Modules\Home\Http\Requests\SalesProcess\ProfileCompletionRequest;
use Modules\Share\Http\Controllers\Controller;
use Modules\User\Services\UserService;

class ProfileCompletionController extends Controller
{
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
        $cartItems = $this->cartRepo->findUserCartItems()->get();
        return view('Home::sales-process.profile-completion',compact(['cartItems']));

    }

    /**
     * @param ProfileCompletionRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileCompletionRequest $request): RedirectResponse
    {
        $this->userService->profileCompletion($request);
        return to_route('customer.sales-process.address-and-delivery');
    }
}
