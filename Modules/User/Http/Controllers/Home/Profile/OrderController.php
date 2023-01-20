<?php

namespace Modules\User\Http\Controllers\Home\Profile;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Order\Repositories\OrderRepoEloquentInterface;
use Modules\Share\Http\Controllers\Controller;

class OrderController extends Controller
{
    public OrderRepoEloquentInterface $orderRepo;

    public function __construct(OrderRepoEloquentInterface $orderRepoEloquent)
    {
        $this->orderRepo = $orderRepoEloquent;
    }

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        if (isset(request()->type)) {
            $orders = $this->orderRepo->findUserOrdersByStatus(request()->type)->get();

        } else {
            $orders = auth()->user()->orders()->latest()->get();
        }
        return view('User::home.profile.orders', compact(['orders']));
    }
}
