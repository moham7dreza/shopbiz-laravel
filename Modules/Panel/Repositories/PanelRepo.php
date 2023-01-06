<?php

namespace Modules\Panel\Repositories;


use Carbon\Carbon;
use Modules\Comment\Entities\Comment;
use Modules\Discount\Entities\AmazingSale;
use Modules\Discount\Entities\CommonDiscount;
use Modules\Order\Entities\Order;
use Modules\Payment\Entities\Payment;
use Modules\Post\Entities\Post;
use Modules\Setting\Entities\Setting;
use Modules\Ticket\Entities\Ticket;
use Modules\User\Entities\User;

class PanelRepo
{
    public function customersCount(): int
    {
        return User::query()->where('user_type', 0)->count();
    }

    public function adminUsersCount(): int
    {
        return User::query()->where('user_type', 1)->count();
    }

    public function postsCount(): int
    {
        return Post::query()->count();
    }

    public function commentsCount(): int
    {
        return Comment::query()->count();
    }

    public function ordersCount(): int
    {
        return Order::query()->count();
    }

    public function paymentsCount(): int
    {
        return Payment::query()->count();
    }

    public function activeAmazingSalesCount(): int
    {
        return AmazingSale::query()->where([
            ['start_date', '<', Carbon::now()],
            ['end_date', '>', Carbon::now()],
            ['status', 1]
        ])->count();
    }

    public function newTicketsCount(): int
    {
        return Ticket::query()->where('seen', 0)->count();
    }

    public function activeCommonDiscount()
    {
        return CommonDiscount::query()->where([
            ['start_date', '<', Carbon::now()],
            ['end_date', '>', Carbon::now()],
            ['status', 1]
        ])->first();
    }

    public function logs()
    {
//        return Log::query()->where([['causer_id', '!=', auth()->id()]])->latest()->paginate(2);
    }

    public function latestComments()
    {
        return Comment::query()->where('author_id', '!=', auth()->id())->latest()->paginate(3);
    }

    public function lavaColumChart()
    {
        $chart = new Lavacharts();
        $data = $chart->DataTable();
        $data->addStringColumn('سال')
            ->addNumberColumn('تعداد')
            ->addRow(['1390', rand(1000, 9000)])
            ->addRow(['1391', rand(1000, 9000)])
            ->addRow(['1392', rand(1000, 9000)])
            ->addRow(['1393', rand(1000, 9000)])
            ->addRow(['1394', rand(1000, 9000)])
            ->addRow(['1395', rand(1000, 9000)])
            ->addRow(['1396', rand(1000, 9000)])
            ->addRow(['1397', rand(1000, 9000)])
            ->addRow(['1398', rand(1000, 9000)])
            ->addRow(['1399', rand(1000, 9000)])
            ->addRow(['1400', rand(1000, 9000)]);
        $chart->ColumnChart('YearCount', $data, [
            'title' => 'تعداد در سال',
            'titleTextStyle' => [
                'fontSize' => 14,
                'color' => 'green',
                'background' => 'red'
            ],
            'elementId' => 'chart_column',
            'fontName' => 'tahoma'
        ]);
        return $chart;
    }

    public function lastMonthlySalesAmount()
    {
        $payments = Payment::query()->latest()->get();
        $start_date = new Carbon('first day of ' . Carbon::now()->format('M') . ' ' . Carbon::now()->format('Y'));
        $end_date = Carbon::now();
        $amount = 0;
        foreach ($payments as $payment) {
            if ($payment->updated_at >= $start_date && $payment->updated_at <= $end_date) {
                $amount += $payment->amount;
            }
        }
        return priceFormat($amount);
    }

    public function lastWeeklySalesAmount()
    {
        $payments = Payment::query()->latest()->get();
        $amount = 0;
        $week = [];
        for ($i = 0; $i < 7; $i++) {
            $week[] = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDay($i)->format('Y-m-d');//push the current day and plus the mount of $i
        }
        foreach ($payments as $payment) {

            if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[0]) {
                $amount += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[1]) {
                $amount += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[2]) {
                $amount += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[3]) {
                $amount += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[4]) {
                $amount += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[5]) {
                $amount += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[6]) {
                $amount += $payment->amount;
            }
        }
        return priceFormat($amount);
    }

    public function lastOrder()
    {
        return Order::query()->orderBy('updated_at', 'desc')->take(1)->first();
    }

    public function customerHomeViewCount(): int
    {
        return Setting::query()->findOrFail(1)->view_count;
    }

    public function browser()
    {
//        return Browser::isDesktop();
    }
}
