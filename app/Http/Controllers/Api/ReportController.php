<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Modules\Payment\Entities\Payment;
use Modules\Share\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function weeklyTotalSales(): JsonResponse
    {
        $payments = Payment::query()->orderBy('updated_at', 'desc')->get();
        $result = [];
        $week = [];
        $weeklyTotalSales = [
            'Sat' => 0,
            'Sun' => 0,
            'Mon' => 0,
            'Tue' => 0,
            'Wed' => 0,
            'Thu' => 0,
            'Fri' => 0,
        ];
        for ($i = 0; $i < 7; $i++) {
            $week[] = Carbon::now()->startOfWeek(Carbon::SATURDAY)->addDay($i)->format('Y-m-d');//push the current day and plus the mount of $i
        }
        foreach ($payments as $payment) {

            if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[0]) {
                $weeklyTotalSales['Sat'] += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[1]) {
                $weeklyTotalSales['Sun'] += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[2]) {
                $weeklyTotalSales['Mon'] += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[3]) {
                $weeklyTotalSales['Tue'] += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[4]) {
                $weeklyTotalSales['Wed'] += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[5]) {
                $weeklyTotalSales['Thu'] += $payment->amount;
            } else if (Carbon::parse($payment->updated_at)->format('Y-m-d') == $week[6]) {
                $weeklyTotalSales['Fri'] += $payment->amount;
            }
        }
        foreach ($weeklyTotalSales as $key => $value) {
            $result[] = ['name' => $key, 'y' => $value];
        }
        return response()->json(['message' => 'مبلغ فروش در طول هفته ی جاری',
            'status' => 'success',
            'data' => $result]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function monthlyTotalSales(): JsonResponse
    {
        $payments = Payment::query()->orderBy('updated_at', 'desc')->get();
        $result = [];
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        $monthlyTotalSales = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];
        for ($i = 0; $i < 12; $i++) {
            if ($i == 11) {
                $start_date = new Carbon('first day of ' . $months[11] . ' ' . Carbon::now()->format('Y'));
                $end_date = new Carbon('first day of ' . $months[0] . ' ' . Carbon::now()->addYear()->format('Y'));
            } else {
                $start_date = new Carbon('first day of ' . $months[$i] . ' ' . Carbon::now()->format('Y'));
                $end_date = new Carbon('first day of ' . $months[$i + 1] . ' ' . Carbon::now()->format('Y'));
            }
            foreach ($payments as $payment) {
                if ($payment->updated_at >= $start_date && $payment->updated_at <= $end_date) {
                    $monthlyTotalSales[$months[$i]] += $payment->amount;
                }
            }
        }
        foreach ($monthlyTotalSales as $key => $value) {
            $result[] = ['name' => $key, 'y' => $value];
        }
        return response()->json(['message' => 'مبلغ فروش در طول سال جاری',
            'status' => 'success',
            'data' => $result]);
    }

    /**
     * @return JsonResponse
     */
    public function monthlyFaTotalSales(): JsonResponse
    {
        $payments = Payment::query()->orderBy('updated_at', 'desc')->get();
        $result = [];
        $faMonths = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];
        $monthlyTotalSales = [
            'فروردین' => 0,
            'اردیبهشت' => 0,
            'خرداد' => 0,
            'تیر' => 0,
            'مرداد' => 0,
            'شهریور' => 0,
            'مهر' => 0,
            'آبان' => 0,
            'آذر' => 0,
            'دی' => 0,
            'بهمن' => 0,
            'اسفند' => 0,
        ];
        for ($i = 0; $i < 12; $i++) {
            if ($i == 0) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-03-21 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-04-21 00:00:00');
            } elseif ($i == 1) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-04-21 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-05-22 00:00:00');
            } elseif ($i == 2) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-05-22 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-06-22 00:00:00');
            } elseif ($i == 3) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-06-22 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-07-23 00:00:00');
            } elseif ($i == 4) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-07-23 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-08-23 00:00:00');
            } elseif ($i == 5) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-08-23 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-09-23 00:00:00');
            } elseif ($i == 6) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-09-23 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-10-23 00:00:00');
            } elseif ($i == 7) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-10-23 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-11-22 00:00:00');
            } elseif ($i == 8) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-11-22 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-12-22 00:00:00');
            } elseif ($i == 9) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2022-12-22 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-21 00:00:00');
            } elseif ($i == 10) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2023-01-21 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2023-02-20 00:00:00');
            } elseif ($i == 11) {
                $start_date = Carbon::createFromFormat('Y-m-d H:i:s', '2023-02-20 00:00:00');
                $end_date = Carbon::createFromFormat('Y-m-d H:i:s', '2023-03-21 00:00:00');
            }
            foreach ($payments as $payment) {
                if ($payment->updated_at >= $start_date && $payment->updated_at <= $end_date) {
                    $monthlyTotalSales[$faMonths[$i]] += $payment->amount;
                }
            }
        }
        foreach ($monthlyTotalSales as $key => $value) {
            $result[] = ['name' => $key, 'y' => $value];
        }
        return response()->json(['message' => 'مبلغ فروش در طول سال جاری',
            'status' => 'success',
            'data' => $result]);
    }
}
