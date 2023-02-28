<?php

namespace Modules\Order\Http\Controllers\Home;

use Artesaos\SEOTools\Facades\SEOTools;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Share\Http\Controllers\Controller;
use Modules\Share\Services\ShareService;
use Modules\Share\Traits\ShowMessageWithRedirectTrait;
use Modules\User\Entities\User;

class OrderController extends Controller
{
    use ShowMessageWithRedirectTrait;

    public function __construct()
    {

    }

    /**
     * @param Order $order
     * @return Application|Factory|View|RedirectResponse
     */
    public function index(Order $order): View|Factory|Application|RedirectResponse
    {
        SEOTools::setTitle('جزئیات سفارش');
        SEOTools::setDescription('جزئیات سفارش');

        if ($order->user_id != auth()->id()) {
            return $this->showAlertWithRedirect(message: 'سفارش موردنظر یافت نشد.', title: 'خطا', type: 'error');
        }
        return view('Order::home.order-received', compact(['order']));
    }

    /**
     * @param Order $order
     * @return Response|RedirectResponse
     */
    public function pdf(Order $order): Response|RedirectResponse
    {
        if ($order->user_id != auth()->id()) {
            return $this->showAlertWithRedirect(message: 'سفارش موردنظر یافت نشد.', title: 'خطا', type: 'error');
        }
//        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $orderPagePdf = Pdf::loadView('Order::home.order-received', compact(['order']));
        ShareService::showAnimatedAlert('فرم در حال دانلود می باشد.');
//        return $orderPagePdf->stream();
        return $orderPagePdf->setPaper('a4', 'landscape')->download( auth()->user()->fullName . '.pdf');
    }
}
