<?php

namespace Modules\Share\Http\Services\Payment;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Config;
use Request;
use Zarinpal\Clients\GuzzleClient;
use Zarinpal\Zarinpal;

class PaymentService
{
    /**
     * @param $amount
     * @param $order
     * @param $onlinePayment
     * @return false|void
     */
    public function zarinpal($amount, $order, $onlinePayment)
    {
        $merchentID = Config::get('payment.zarinpal_api_key');
        $sandbox = false;
        $zarinpalGate = false;
        $client = new GuzzleClient($sandbox);
        $zarinpalGatePSP = '';
        $lang = 'fa';
        $zarinpal = new Zarinpal($merchentID, $client, $lang, $sandbox, $zarinpalGate, $zarinpalGatePSP);
        $payment = [
            'callback_url' => route('customer.sales-process.payment-call-back', [$order, $onlinePayment]),
            'amount' => (int)$amount * 10,
            'description' => 'the order',
        ];
        try {
            $response = $zarinpal->request($payment);
            $code = $response['data']['code'];
            $message = $zarinpal->getCodeMessage($code);
            if ($code === 100) {
                $onlinePayment->update(['bank_first_response' => ($response)]);
                $authority = $response['data']['authority'];
                return $zarinpal->redirect($authority);
            }
        } catch (RequestException $exception) {
            return false;
        }
    }


    /**
     * @param $amount
     * @param $onlinePayment
     * @return false[]|true[]
     */
    public function zarinpalVerify($amount, $onlinePayment): array
    {
        $authority = $_GET['Authority'];
        $data = ['merchant_id' => Config::get('payment.zarinpal_api_key'), 'authority' => $authority, 'amount' => (int)$amount];
        $jsonData = json_encode($data);
        $ch = curl_init('https://api.zarinpal.com/pg/v4/payment/verify.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v4');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        $onlinePayment->update(['bank_second_response' => $result]);
        if (count($result['errors']) === 0) {
            if ($result['data']['code'] == 100) {
                return ['success' => true];
            } else {
                return ['success' => false];
            }
        } else {
            return ['success' => false];
        }
    }


    /**
     * @param $code
     * @return string
     */
    function resultCodes($code): string
    {
        return match ($code) {
            100 => "با موفقیت تایید شد",
            102 => "merchant یافت نشد",
            103 => "merchant غیرفعال",
            104 => "merchant نامعتبر",
            105 => "amount بایستی بزرگتر از 1,000 ریال باشد",
            106 => "callbackUrl نامعتبر می‌باشد. (شروع با http و یا https)",
            113 => "amount مبلغ تراکنش از سقف میزان تراکنش بیشتر است.",
            201 => "قبلا تایید شده",
            202 => "سفارش پرداخت نشده یا ناموفق بوده است",
            203 => "trackId نامعتبر می‌باشد",
            default => "وضعیت مشخص شده معتبر نیست",
        };
    }

    /**
     * returns a string message based on status parameter from $_GET
     * @param $code
     * @return String
     */
    function statusCodes($code): string
    {
        return match ($code) {
            -1 => "در انتظار پردخت",
            -2 => "خطای داخلی",
            1 => "پرداخت شده - تاییدشده",
            2 => "پرداخت شده - تاییدنشده",
            3 => "لغوشده توسط کاربر",
            4 => "‌شماره کارت نامعتبر می‌باشد",
            5 => "‌موجودی حساب کافی نمی‌باشد",
            6 => "رمز واردشده اشتباه می‌باشد",
            7 => "‌تعداد درخواست‌ها بیش از حد مجاز می‌باشد",
            8 => "‌تعداد پرداخت اینترنتی روزانه بیش از حد مجاز می‌باشد",
            9 => "مبلغ پرداخت اینترنتی روزانه بیش از حد مجاز می‌باشد",
            10 => "‌صادرکننده‌ی کارت نامعتبر می‌باشد",
            11 => "خطای سوییچ",
            12 => "کارت قابل دسترسی نمی‌باشد",
            default => "وضعیت مشخص شده معتبر نیست",
        };
    }
}
