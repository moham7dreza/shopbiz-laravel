<?php

namespace Modules\Order\Http\Controllers\Home;

use Artesaos\SEOTools\Facades\SEOTools;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;

class OrderController extends Controller
{
    use ShowMessageWithRedirectTrait;

    /**
     * @param Order $order
     * @param Payment $payment
     * @param User $user
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Order $order, Payment $payment, User $user): View|Factory|Application|RedirectResponse
    {
        SEOTools::setTitle('جزئیات سفارش');
        SEOTools::setDescription('جزئیات سفارش');

        if ($order->user_id != auth()->id()) {
            return $this->showAlertWithRedirect(message: 'سفارش موردنظر یافت نشد.', title: 'خطا', type: 'error');
        }
        return view('Order::home.order-received', compact(['order', 'payment']));
    }
}
