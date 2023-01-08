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
}
