<?php

namespace Modules\Payment\Traits;

use Carbon\Carbon;

trait SaleCalculator
{
    /**
     * @param $payments
     * @return array|string|string[]
     */
    public function lastWeekSalesAmount($payments): array|string
    {
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

    /**
     * @param $payments
     * @return array|string|string[]
     */
    public function lastMonthSalesAmount($payments): array|string
    {
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
}
