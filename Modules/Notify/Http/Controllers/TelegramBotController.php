<?php

namespace Modules\Notify\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Modules\Share\Http\Controllers\Controller;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Modules\Share\Services\ShareService;

class TelegramBotController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function message(): View|Factory|Application
    {
        return view('Notify::bot.message');
    }

    public function sendMessage(Request $request)
    {
        //        $update = json_decode(file_get_contents('php://input'), true);
        $bot = new \basicbot();

        $responses = $bot->getDataFromApis();


//        dd(json_decode($this->apiRequest('/setWebhook', ['url' => 'https://localhost/php-project/index.php'])));
        $updates = json_decode($bot->apiRequest('getUpdates', []));
        dump($updates);
//        $updates = json_decode($this->apiRequest('/getWebhookInfo', []));dd($updates);
        if ($updates->ok) {
//            foreach ($updates->result as $update) {
            $update = end($updates->result);

            if (isset($update->message)) {
                $username = $update->message->from->username;
                $chat_id = $update->message->chat->id;
                $id = $update->message->from->id;
                $fname = $update->message->from->first_name;
                if (isset($update->message->from->last_name)) {
                    $lname = $update->message->from->last_name;
                }
                $text = $update->message->text;

                switch ($text) { //commands
                    case "/notification":
                        {
                            $req = $this->findUserNotifications(1);
                            if (count($req->data) > 0) {
                                $bot->SendMessage($chat_id, $req->message);
                                foreach ($req->data as $data) {
                                    $bot->SendMessage($chat_id, $data->notify_data);
                                }
                            }
                            dd(1);
                            $data = $responses['notifs']->successful() ? $responses['notifs']->json()['data'] : null;
                            if ($data) {
                                dump($data);
                                $bot->SendMessage($chat_id, $responses['notifs']->json()['message']);
                            } else {
                                $bot->SendMessage($chat_id, 'اطلاعاتی از نوتیف ها برای نمایش وجود ندارد.');
                            }
                        }
                        break;
                    case "/orders":
                        {
                            $req = $this->sendNewOrdersReqForOrderApi();
                            if (count($req->data) > 0) {
                                $bot->SendMessage($chat_id, $req->message);
                                foreach ($req->data as $data) {
                                    $orderExplain = $data->order_user_name . ' _ ' . $data->order_payment_status . ' _ ' . $data->order_final_amount . ' _ ' . $data->order_status;
                                    $bot->SendMessage($chat_id, $orderExplain);
                                }
                            }
                            dd(1);
                            $data = $responses['orders']->successful() ? $responses['orders']->json()['data'] : null;
                            if ($data) {
                                $bot->SendMessage($chat_id, $responses['orders']->json()['message']);
                            } else {
                                $bot->SendMessage($chat_id, 'اطلاعاتی از سفارشات برای نمایش وجود ندارد.');
                            }
                        }
                        break;
                    case "/products":
                        {
                            $req = $this->sendLowCountReqForProductApi();
                            if (count($req->data) > 0) {
                                $bot->SendMessage($chat_id, $req->message);
                                foreach ($req->data as $data) {
                                    $bot->SendPhotof($chat_id, $data->product_image, $data->product_name);
                                    $bot->SendMessage($chat_id, 'تعداد قابل فروش : ' . $data->product_marketable_number);
                                }
                            }

                            dd(1);
//                            $data = $responses['products']->successful() ? $responses['products']->json()['data'] : null;
                            if ($data) {
//                                $bot->SendMessage($chat_id, $responses['products']->json()['message']);
                            } else {
                                $bot->SendMessage($chat_id, 'اطلاعاتی از محصولات برای نمایش وجود ندارد.');
                            }
                        }
                        break;
                    case "/comments":
                        {
                            $req = $this->unseenParentProductComments();
                            if (count($req->data) > 0) {
                                $bot->SendMessage($chat_id, $req->message);
                                foreach ($req->data as $data) {
                                    $commentExplain = $data->comment_author . ' : ' . $data->comment_body . ' _ ' . $data->comment_approved . ' => ' . $data->commentable_name;
                                    $bot->SendMessage($chat_id, $commentExplain);
                                }
                            }

                            dd(1);
                            $data = $responses['comments']->successful() ? $responses['comments']->json()['data'] : null;
                            if ($data) {
                                $bot->SendMessage($chat_id, $responses['comments']->json()['message']);
                            } else {
                                $bot->SendMessage($chat_id, 'اطلاعاتی از نظرات برای نمایش وجود ندارد.');
                            }
                        }
                        break;
                    case "/commands":
                        {
                            $keyboard = [
                                [
                                    ['text' => "سفارشات", "callback_data" => "1"],
                                    ['text' => 'کامنت ها', "callback_data" => "2"],
                                    ['text' => 'محصولات', "callback_data" => "3"],
                                    ['text' => 'نوتیف ها', "callback_data" => "4"]
                                ],
                            ];
                            $bot->SendIK($chat_id, $keyboard, 'دستورات');
                        }
                        break;
                    default :
                        $bot->SendMessage($chat_id, 'اطلاعاتی از پیام وارد شده برای نمایش وجود ندارد.');
                        break;
                }
            } elseif (isset($update->callback_query)) //answer to queez
            {
                $msg_flag = false;
                $chat_id = $update->callback_query->from->id;
                if (isset($update->callback_query->message)) {
                    $chat_id = $update->callback_query->message->chat->id;
                    $message_id = $update->callback_query->message->message_id;
                    $msg_flag = true;
                }
                $callback_data = $update->callback_query->data;
                dump($update->callback_query);
                $callback_id = $update->callback_query->id;
                switch ($callback_data) { //commands
                    case "4":
                        {
                            $data = $responses['notifs']->successful() ? $responses['notifs']->json()['data'] : null;
                            dump($data);
                            if ($data) {

                                $bot->AnswerCBquery($callback_id, $responses['notifs']->json()['message']);
//                                $this->sendMessageTel($chat_id, $responses['notifs']->json()['message']);
                            } else {
                                $bot->SendMessage($chat_id, 'اطلاعاتی برای نمایش وجود ندارد.');
                            }
                        }
                        break;
                    case "1":
                        {
                            $data = $responses['orders']->successful() ? $responses['orders']->json()['data'] : null;
                            if ($data) {
                                $bot->AnswerCBquery($callback_id, $responses['orders']->json()['message']);
                            } else {
                                $bot->SendMessage($chat_id, 'اطلاعاتی برای نمایش وجود ندارد.');
                            }
                        }
                        break;
                    case "3":
                        {
                            $req = $this->sendReqForProductApi();
                            if (count($req->data) > 0) {
                                $bot->SendMessage($chat_id, $req->message);
                                foreach ($req->data as $data) {
                                    $bot->SendMessage($chat_id, $data->product_name . ' -> ' . $data->product_marketable_number);
                                }
                            }
                            dd(1);
                            $data = $responses['products']->successful() ? $responses['products']->json()['data'] : null;
                            if ($data) {
                                $bot->AnswerCBquery($callback_id, $responses['products']->json()['message']);
                            } else {
                                $bot->SendMessage($chat_id, 'اطلاعاتی برای نمایش وجود ندارد.');
                            }
                        }
                        break;
                    case "2":
                        {
                            $data = $responses['comments']->successful() ? $responses['comments']->json()['data'] : null;
                            if ($data) {
                                $bot->AnswerCBquery($callback_id, $responses['comments']->json()['message']);
                            } else {
                                $bot->SendMessage($chat_id, 'اطلاعاتی برای نمایش وجود ندارد.');
                            }
                        }
                        break;
                    default :
                        $bot->SendMessage($chat_id, 'اطلاعاتی برای نمایش وجود ندارد.');
                        break;
                }
            } elseif (isset($update->inline_query)) {
                $id = $update->inline_query->from->id;
                $name = $update->inline_query->from->first_name;
                $user_name = $update->inline_query->from->username;
                $query_id = $update->inline_query->id;
                $query = $update->inline_query->query;
                if (strlen($query) > 1) {
                    dump($query);
                    $greet = $bot->Greeting();
                    $bot->SendMessage($id, $greet);
//                    $products = $bot->getProductsFromApi($query);
                    $req_res = $this->sendSearchReqForProductApi($query);
//                    $data = $products->successful() ? $products->json()['data'] : null;
                    if (1) {
//                        dump($data);
                        $q_result = [];
                        $qid = 1;
                        foreach ($req_res->data as $product) {
                            $product_name = $product->product_name;
                            $product_url = $product->product_url;
                            $product_price = $product->product_price;
                            $product_category_name = $product->product_category_name;
                            $product_image = $product->product_image;
                            $product_intro = $product->product_intro;
                            $IK_Product =
                                [
                                    [
                                        ['text' => "لینک محصول", "url" => $product_url], ['text' => "اطلاعات بیشتر", "url" => "localhost:8000"],
                                    ],
                                    [
                                        ['text' => "عضویت در کانال تلگرامی", "url" => "https://t.me/techzilla_market"], ['text' => "ارسال به دوستان", "switch_inline_query" => ""],
                                    ],
                                    [
                                        ['text' => "صفحه اینستاگرام ما", 'url' => "https://www.instagram.com/moham7dreza/"],
                                    ],
                                    [
                                        ['text' => "اپلیکیشن اندرویدی", "url" => "https://t.me/techzilla_market"]
                                    ],
                                    [
                                        ['text' => "Designed And Developed with 💙 by Mohamadreza", "url" => "https://t.me/techzilla_market"]
                                    ]
                                ];
                            $result = [
                                'type' => 'article',
                                'id' => $qid,
                                'input_message_content' => [
                                    'parse_mode' => 'Markdown',
                                    'message_text' =>
                                        "*" . $product_name . "*

_" . $product_category_name . "_

☎ 044-33388175
مشاوره
[@Support](tg://user?id=" . $bot->developer . ")" . " [🖥️](" . $product_image . ")",
                                ],
                                'title' => $product_name,
                                'description' => $product_intro,
                                'thumb_url' => $product_image,
                                'reply_markup' => ['inline_keyboard' => $IK_Product],
                                'url' => $product_url,
                                'hide_url' => false,
                            ];
                            $q_result[] = $result;
                            $qid++;
                        }
                        $res = $bot->AnswerInlineQuery($query_id, $q_result);
                        dd($res);
                        $bot->SendMessage($id, $res);
                    } else {
                        $bot->SendMessage($id, 'اطلاعاتی از کوئری شما برای نمایش وجود ندارد.');
                    }
                } else {
                    $bot->SendMessage($id, 'کوئری وارد شده باید بیشتر از یک کاراکتر باشد.');
                }
            } else {
                $bot->SendMessage($bot->developer, 'اطلاعاتی برای نمایش وجود ندارد.');
            }
        } else {
            $bot->SendMessage($bot->developer, 'مشکل بروزرسانی اطلاعات از سرور');
        }

//        return redirect()->back()->with('swal-success', 'پیام با موفقیت ارسال شد.');


//        $result = json_decode($this->sendMessageTo($chat_id, 'اطلاعاتی برای نمایش وجود ندارد.'));
//        if($result->ok){
//            return redirect()->back()->with('swal-success', 'پیام با موفقیت ارسال شد.');
//        }
//        return redirect()->back()->with('swal-alert', 'خطایی در ارسال پیام رخ داد.');
    }

    function sendTelegram($chatID, $msg)
    {
        $token = "bot5763941835:AAFo0FE8odI2985KuQC02k9Zq2I2lrxwCgc";
        $getUpdate = "http://api.telegram.org/" . $token . "/getUpdates";

        $url = "https://api.telegram.org/" . $token . "/sendMessage?chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($msg);

        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false
        );
        curl_setopt_array($ch, $optArray);
        if (curl_error($ch)) {
            echo('error:' . curl_error($ch));
        }
        $result = curl_exec($ch);

        curl_close($ch);
        return $result;
    }

    function sendMessageTo($chat_id, $text)
    {
        $botToken = "5763941835:AAFo0FE8odI2985KuQC02k9Zq2I2lrxwCgc";

        $website = "https://api.telegram.org/bot" . $botToken;
        $params = [
            'chat_id' => $chat_id,
            'text' => $text,
        ];
        $ch = curl_init($website . '/sendMessage');
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    function allApis()
    {
        return Http::acceptJson()->pool(fn(Pool $pool) => [
            $pool->as('notifs')->get('127.0.0.1:8001/api/admin/notification/all'),
            $pool->as('products')->get('127.0.0.1:8000/api/admin/market/product/all'),
            $pool->as('orders')->get('127.0.0.1:8001/api/admin/market/order/all'),
            $pool->as('comments')->get('127.0.0.1:8001/api/admin/market/comment/all'),
        ]);
    }

    function apiRequest($method, $parameters)
    {
        $botToken = "5763941835:AAFo0FE8odI2985KuQC02k9Zq2I2lrxwCgc";
        $url = "https://api.telegram.org/bot" . $botToken . $method;
        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        //return exec_curl_request($handle);
        $result = curl_exec($handle);
        curl_close($handle);
        return $result;
    }

    function SendMessageTel($id, $text)
    {
        $this->apiRequest("/sendMessage", array(
                'chat_id' => $id,
                'text' => $text
            )
        );
    }

    private function sendReqForProductApi()
    {
        $request = Request::create(route('api.product.index'), 'get');

        return json_decode(Route::dispatch($request)->getContent());
    }

    private function sendSearchReqForProductApi($name)
    {
        $request = Request::create(route('api.product.search', 'name=' . $name), 'get');

        return json_decode(Route::dispatch($request)->getContent());
    }

    private function sendLowCountReqForProductApi()
    {
        $request = Request::create(route('api.product.low-count'), 'get');

        return json_decode(Route::dispatch($request)->getContent());
    }

    private function sendNewOrdersReqForOrderApi()
    {
        return ShareService::sendInternalApiRequestAndGetResponse('api.order.new');
    }

    public function findUserNotifications($id)
    {
        return ShareService::sendInternalApiRequestAndGetResponse('api.notify.user.notifications', [$id]);
    }

    public function unseenParentProductComments()
    {
        return ShareService::sendInternalApiRequestAndGetResponse('api.product.unseen.primary.comments');
    }
}
