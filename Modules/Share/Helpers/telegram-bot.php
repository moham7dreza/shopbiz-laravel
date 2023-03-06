<?php

/**
 * Created by PhpStorm.
 * User: M
 * Date: 04/01/2017
 * Time: 07:03 PM
 */

// Load all configuration options
/** @var array $config */
$config = require __DIR__ . '/config.php';

use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\Http;

const BOT_TOKEN = "5763941835:AAFo0FE8odI2985KuQC02k9Zq2I2lrxwCgc";
const API_URL = "https://api.telegram.org/bot5763941835:AAFo0FE8odI2985KuQC02k9Zq2I2lrxwCgc/";

class basicbot
{

    public $developer = "248824780";

    public function Greeting()
    {
        date_default_timezone_set('Asia/Tehran');

        $greet = "سلام";
        $h = date('H');
        if ($h > 4 && $h < 10) {
            $greet = "سلام صبح بخیر";
        }
        if ($h >= 10 && $h < 12) {
            $greet = "سلام روزتون بخير و خوشي";
        }
        if ($h >= 12 && $h < 15) {
            $greet = "سلام ظهر دانشجوییت بخير";
        }
        if ($h >= 15 && $h < 17) {
            $greet = "سلام بعد از ظهرتون بخير";
        }
        if ($h >= 17 && $h < 19) {
            $greet = "سلام عصرتون بخير";
        }
        if ($h >= 19 && $h < 24) {
            $greet = "سلام شبتون بخير و خوشي";
        }
        if ($h >= 0 && $h <= 4) {
            $greet = "سلام😦. آغا من شرمندم این رفیقمون گیر داده نصف شبی منو بهتون معرفی کنه ";
        }

        return $greet;
    }

    public function getProductsFromApi($name)
    {
        return Http::acceptJson()->get('127.0.0.1:8001/api/admin/market/product/show?name=' . $name);
    }

    public function getDataFromApis()
    {
        return Http::acceptJson()->pool(fn(Pool $pool) => [
            $pool->as('notifs')->get('127.0.0.1:8000/api/admin/notify/all'),
            $pool->as('products')->get('127.0.0.1:8000/api/product/index'),
//            $pool->as('products')->get(route('api.product.index')),
            $pool->as('orders')->get('127.0.0.1:8000/api/admin/market/order/all'),
            $pool->as('comments')->get('127.0.0.1:8000/api/admin/market/comment/all'),
        ]);
    }

    public function apiProductRequest()
    {
        $handle = curl_init('127.0.0.1:8001/api/admin/market/product/all');
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        //return exec_curl_request($handle);
        $result = curl_exec($handle);
        curl_close($handle);
        return $result;
    }

    public function apiRequest($method, $parameters)
    {
        $url = API_URL . $method;


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

    public function apiRequestR($method, $parameters)
    {
        $url = API_URL . $method;


        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
        //return exec_curl_request($handle);
        $user = curl_exec($handle);
        curl_close($handle);
        return $user;
    }

    public function apiRequestP($method, $parameters)
    {
        $url = API_URL . $method;


        $handle = curl_init($url);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Content-Type: multipart/form-data"));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
        //return exec_curl_request($handle);
        curl_exec($handle);
        curl_close($handle);
    }

    public function apiRequestI($post)
    {
        $url = API_URL . "answerInlineQuery";
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
//        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public function AnswerInlineQuery($query_id, $inline_query_results)
    {
        $post =
            [
                "inline_query_id" => "$query_id",
                "results" => json_encode($inline_query_results)
            ];

        return $this->apiRequestI($post);
    }


    public function edit_caption($chatid = null, $message_id = null, $inline_message_id = null, $caption = null, $reply_markup = null)
    {
        $data = array();
        if (isset($chatid)) $data["chat_id"] = $chatid;
        if (isset($message_id)) $data["message_id"] = $message_id;
        if (isset($inline_message_id)) $data["inline_message_id"] = $inline_message_id;
        if (isset($caption)) $data["caption"] = $caption;
        if (isset($reply_markup)) $data["reply_markup"] = $reply_markup;
        $response = $this->control_api("/editMessageCaption", $data);
        return $response;
    }

    public function edit_replymarkup($chatid = null, $message_id = null, $inline_message_id = null, $reply_markup = null)
    {
        $data = array();
        if (isset($chatid)) $data["chat_id"] = $chatid;
        if (isset($message_id)) $data["message_id"] = $message_id;
        if (isset($inline_message_id)) $data["inline_message_id"] = $inline_message_id;
        if (isset($reply_markup)) $data["reply_markup"] = $reply_markup;
        $response = $this->control_api("/editMessageReplyMarkup", $data);
        return $response;
    }

    private function open_url($url, $method = "GET", $data = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($method === "POST") {
            if (isset($data)) curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        return curl_exec($ch);
    }

    private function control_api($action, $data = NULL)
    {
        $token = BOT_TOKEN;
        $response = json_decode($this->open_url("https://api.telegram.org/bot$token$action", "POST", $data));
        return $response;
    }

    public function send_action($to, $action)
    {
        $data = array();
        $data["chat_id"] = $to;
        $data["action"] = $action;
        $response = $this->control_api("/sendChatAction", $data);
        return $response;
    }


    //ok
    public function SendMessage($id, $text)
    {
        $this->apiRequest("sendMessage", array(
                'chat_id' => $id,
                'text' => $text
            )

        );

    }

    public function DeleteMessage($chat_id, $message_id)
    {
        $this->apiRequest("DeleteMessage", array(
                'chat_id' => $chat_id,
                'message_id' => $message_id
            )

        );

    }

    //khabari
    public function SendPhotof($id, $filename, $caption)
    {

        $this->apiRequestP('sendPhoto', ['chat_id' => $id,
            'photo' => new CURLFile(realpath("$filename")),
            'caption' => $caption
        ]);
    }

    //khabari
    public function SendDocument($chat_id, $file_id, $caption = null)
    {
        $this->apiRequest('sendDocument', [
            'chat_id' => $chat_id,
            'document' => $file_id,
            'caption' => $caption

        ]);
    }

    public function SendDocIK($chat_id, $file_id, $caption, $IK)
    {
        $this->apiRequest('sendDocument', [
            'chat_id' => $chat_id,
            'document' => $file_id,
            'caption' => $caption,
            'reply_markup' => [
                'inline_keyboard' => $IK
            ]
        ]);
    }

    public function SendVideo($chat_id, $file_id, $caption = null)
    {
        $this->apiRequest('sendVideo', [
            'chat_id' => $chat_id,
            'video' => $file_id,
            'caption' => $caption

        ]);
    }

    public function SendVideoIK($chat_id, $file_id, $caption, $IK)
    {
        $this->apiRequest('sendVideo', [
            'chat_id' => $chat_id,
            'video' => $file_id,
            'caption' => $caption,
            'reply_markup' => [
                'inline_keyboard' => $IK
            ]

        ]);
    }

    public function SendAudio($chat_id, $file_id, $caption = null)
    {
        $this->apiRequest('sendAudio', [
            'chat_id' => $chat_id,
            'audio' => $file_id,
            'caption' => $caption

        ]);
    }

    public function SendAudioIK($chat_id, $file_id, $caption, $IK)
    {
        $this->apiRequest('sendAudio', [
            'chat_id' => $chat_id,
            'audio' => $file_id,
            'caption' => $caption,
            'reply_markup' => [
                'inline_keyboard' => $IK
            ]

        ]);
    }

    public function SendPhotofid($id, $field, $caption)
    {

        $this->apiRequestP('sendPhoto', ['chat_id' => $id,
            'photo' => $field,
            'caption' => $caption
        ]);
    }

    public function SendMK($id, $keyboard, $text)
    {

        $this->apiRequest('sendMessage', [
            'chat_id' => $id,
            'text' => "$text",
            'reply_markup' => [
                'keyboard' => $keyboard,
                "resize_keyboard" => true,
                "one_time_keyboard" => false
            ]

        ]);

    }

    public function send_photo($to, $photo, $caption = null, $id_msg = null, $reply = null)
    {
        $this->send_action($to, "upload_photo");
        $data = array();
        $data["chat_id"] = $to;
        if (substr($photo, 0, 1) == "@") $photo = substr($photo, 1); // support for "@$filename"
        if (file_exists($photo)) {
            if (class_exists('CurlFile', false)) $photo = new CURLFile(realpath($photo));
            else $photo = "@" . $photo;
        }
        $data["photo"] = $photo;
        if (isset($caption)) $data["caption"] = $caption;
        if (isset($id_msg)) $data["reply_to_message_id"] = $id_msg;
        if (isset($reply)) $data["reply_markup"] = $reply;
        $response = $this->control_api("/sendPhoto", $data);
        return $response;
    }


    //khabari
    public function ChangeIKMark($IK, $data)
    {


        for ($i = 0; $i < count($IK); $i++)
            for ($j = 0; $j < count($IK[$i]); $j++) {
                if ($IK[$i][$j]["callback_data"] == $data)
                    $IK[$i][$j]["text"] = $IK[$i][$j]["text"] . " ✅";
            }

        return $IK;
    }


    //ok
    public function AnswerCBquery($c_id, $text)
    {
        $this->apiRequest('answerCallbackQuery', [
            'callback_query_id' => $c_id,
            'text' => $text
        ]);
    }

    //ok
    public function SendIK($id, $IK, $text)
    {

        $this->apiRequest('sendMessage', [
            'chat_id' => $id,
            'text' => "$text",
            'reply_markup' => [
                'inline_keyboard' => $IK
            ]

        ]);

    }

    //khabari
    public function SendPCIK($id, $IK, $field, $caption)
    {

        $this->apiRequest('sendphoto', [
            'chat_id' => $id,
            'photo' => $field,
            'caption' => $caption,
            'reply_markup' => [
                'inline_keyboard' => $IK
            ]

        ]);

    }

    //khabari
    public function SendPIK($id, $IK, $field)
    {

        $this->apiRequest('sendphoto', [
            'chat_id' => $id,
            'photo' => $field,

            'reply_markup' => [
                'inline_keyboard' => $IK
            ]

        ]);

    }

    public function EditMessage($id, $message_id, $text)
    {

        $this->apiRequest('editMessageText', [
            'chat_id' => $id,
            'message_id' => $message_id,
            'text' => $text,

        ]);

    }


    public function EditMA($id, $message_id, $text)
    {

        $this->apiRequest('editMessageText', [
            'chat_id' => $id,
            'message_id' => $message_id,
            'text' => $text,
            'parse_mode' => "Markdown"


        ]);

    }

    public function EditMAIK($id, $IK, $message_id, $text)
    {

        $this->apiRequest('editMessageText', [
            'chat_id' => $id,
            'message_id' => $message_id,
            'text' => $text,
            'parse_mode' => "Markdown",
            'reply_markup' => [
                'inline_keyboard' => $IK
            ]

        ]);

    }


    //ok
    public function EditMIK($id, $IK, $message_id, $text)
    {

        $this->apiRequest('editMessageText', [
            'chat_id' => $id,
            'message_id' => $message_id,
            'text' => $text,
            'reply_markup' => [
                'inline_keyboard' => $IK
            ]

        ]);

    }

    public function EditPCIK($id, $IK, $message_id, $caption)
    {

        $this->apiRequest('editMessageText', [
            'chat_id' => $id,
            'message_id' => $message_id,
            'caption' => $caption,
            'reply_markup' => [
                'inline_keyboard' => $IK
            ]

        ]);

    }

    //khabari
    public function EditIK($id, $IK, $message_id)
    {

        $this->apiRequest('editMessageReplyMarkup', [
            'chat_id' => $id,
            'message_id' => $message_id,
            'reply_markup' => [
                'inline_keyboard' => $IK
            ]

        ]);
    }

    //khabari
    public function Forward($id, $from, $message_id)
    {
        $this->apiRequest('ForwardMessage', [
            'chat_id' => $id,
            'from_chat_id' => $from,
            'message_id' => $message_id
        ]);
    }

    public function SendMRemoveKB($id, $text)
    {
        $this->apiRequest('sendMessage', [
            'chat_id' => $id,
            'text' => $text,
            'reply_markup' =>
                [
                    "remove_keyboard" => true
                ]
        ]);
    }


    public function SendPhotoList($id)
    {
        for ($n = 1; $n <= 20; $n++) {
            $this->apiRequestP('sendPhoto', ['chat_id' => $id,
                'photo' => new CURLFile(realpath("zar{$n}.jpg")),
                'caption' => " عکس شماره $n",
            ]);
        }

    }

    public function GetAdressByitsLocation($longitude, $latitude, $option)
    {

        $geocode = file_get_contents("http://maps.googleapis.com/maps/api/geocode/json?latlng=$latitude,$longitude&sensor=false");

        $output = json_decode($geocode, true);

        $result = "نامشخص";

        if ($option == "route") $result = $output['results'][0]['address_components'][0]['long_name'];  //route
        elseif ($option == "city") $result = $output['results'][0]['address_components'][1]['long_name'];  //city
        elseif ($option == "province") $result = $output['results'][0]['address_components'][2]['long_name'];  //ostan
        elseif ($option == "country") $result = $output['results'][0]['address_components'][3]['long_name'];  //keshvar
        elseif ($option == "address") $result = $output['results'][0]['formatted_address']; //adres

        return $result;
    }

    public function VardumpToString($id, $input)
    {
        ob_start();
        var_dump($input);
        $p = ob_get_clean();
        $this->SendMessage($id, $p);
    }

}


class telegrambot extends basicbot
{
    protected $servername = "localhost";
    protected $username = "lifedev_mohammad";
    protected $password = "qweRTY123$%^";
    protected $dbname = "lifedev_mohammad";


    public function SetDBConfig($servername, $username, $password, $dbname)
    {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

    }

    public function CreateConn()
    {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        $conn->set_charset("utf8mb4");
        return $conn;


    }


    public function SelectfromDB($id, $column, $table)
    {

        $conn = $this->CreateConn();

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());

        }


        $sql = "SELECT $column FROM $table where telegram = '$id' ";

        $result = $conn->query($sql);


        $row = $result->fetch_assoc();


        $selected = $row['$column'];

        //ta inja ok


        mysqli_close($conn);
        return $selected;
    }

    public function SelectRecordfromDB($id, $table)
    {
        $conn = $this->CreateConn();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());

        }


        $sql = "SELECT * FROM $table where telegram = '$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        foreach (array_keys($row) as $key)
            $selected["$key"] = $row["$key"];
        /*$selected["firstname"] = $row["firstname"];
        $selected["lastname"] = $row["lastname"];
        $selected["mobile"] = $row["mobile"];
        $selected["city"] = $row["city"];*/
        //ta inja ok
//SendMessage($id,"select record ... fname : ".$row["firstname"]."--".$row["lastname"]."--".$row["mobile"]."--".$row["city"]);

        mysqli_close($conn);
        return $selected;
    }

    public function UpdateColInDB($id, $table, $col, $value, $where = null, $equal = null)
    {


        $conn = $this->CreateConn();

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
            $this->apiRequest("sendMessage", array('chat_id' => $this->developer, 'text' => "InsertUserInDBifNE has connection error" . mysqli_connect_error()));
        }


        //safe sazi
        $value = mysqli_real_escape_string($conn, $value);


        $sql = "UPDATE $table SET $col = '$value' where $where = '$equal'";


        if ($conn->query($sql)) {
            // $this->apiRequest("sendMessage", array('chat_id' => $id,'text'=>"ویرایش موفق" ));
        } else {
            //   $this->apiRequest("sendMessage", array('chat_id' => $id,'text'=>"  ویرایش ناموفق" ));
        }

        mysqli_close($conn);


    }


    public function CheckUserInDB($id, $table)
    {

        $conn = $this->CreateConn();

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
            $this->apiRequest("sendMessage", array('chat_id' => $this->developer, 'text' => "CheckUserInDB has error in connection" . mysqli_connect_error()));
        }


        //add if not exist
        $sql = "SELECT * FROM $table where telegram = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return true;
        } else {
            return false;
        }

        mysqli_close($conn);

    }

    public function ExcuteThisSql($sql1, $sql2)
    {

        $conn = $this->CreateConn();

        // Check connection

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
            $this->apiRequest("sendMessage", array('chat_id' => $this->developer, 'text' => "InsertUserInDBifNE has connection error" . mysqli_connect_error()));
        }
        $flag = false;
        if (isset($sql1)) {

            $result = $conn->query($sql1);

            if (isset($sql2))
                $flag = $result->num_rows > 0;
            else
                return $result;
        }


        if ($flag) {
            // $this->apiRequest("sendMessage", array('chat_id' => $id,'text'=>"پرونده شما در سیستم موجود است ." ));
        } else {

            $result = $conn->query($sql2);
            return $result;

        }


        mysqli_close($conn);


    }


    /*
        public function CountItemsNum($column,$table ,$whereCol , $whereVal)
        {
            $conn = $this->CreateConn();

            // Check connection
            if (!$conn) {
                $this->apiRequest("sendMessage", array('chat_id' =>  $this->developer,'text'=>"CountUserVotes has error in connection".mysqli_connect_error() ));
                die("Connection failed: " . mysqli_connect_error());
            }




            //add if not exist
            $sql = "SELECT count($column) as total from $table where $whereCol = '$whereVal'";
            $result=$conn->query($sql);
            $dataset=$result->fetch_assoc();

            return $dataset['total'];

            mysqli_close($conn);
        }
    */
    public function GetPhotoFileId($message)
    {
        $lastnum = count($message['photo']);
        return $message['photo'][$lastnum - 1]['file_id'];
    }

//khabari
    public function InsertSomeCols($id, $colsname, $values, $table, $where, $equal)
    {

        $conn = $this->CreateConn();


        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
            $this->apiRequest("sendMessage", array('chat_id' => $this->developer, 'text' => "InsertUserInDBifNE has connection error" . mysqli_connect_error()));
        }
        $cname = implode(",", $colsname);

        $vals = "";
        $n = sizeof($values) - 1;
        for ($i = 0; $i <= $n; $i++) {
            if ($i < $n)
                $vals .= "'$values[$i]',";
            else
                $vals .= "'$values[$i]'";
        }

        //add if not exist
        $flag = false;
        if (isset($where) && isset($equal)) {
            $sql = "SELECT $cname FROM $table where $where = '$equal'";
            $result = $conn->query($sql);
            $flag = $result->num_rows > 0;
        }


        if ($flag) {
            // $this->apiRequest("sendMessage", array('chat_id' => $id,'text'=>"پرونده شما در سیستم موجود است ." ));
        } else {
            $sql = "INSERT INTO $table ($cname) VALUES ($vals)";
            $result = $conn->query($sql);
            if ($result) {
                //  $this->apiRequest("sendMessage", array('chat_id' => $id,'text'=>"ثبت نام با موفقیت انجام شد. 👍
//برای دادن رای تایید و ثبت رای را انتخاب کنید." ));
            } else {
                //  $this->apiRequest("sendMessage", array('chat_id' => $id,'text'=>"مشخصات شما قبلا در سیستم ثبت شده است
                //برای دادن رای تایید و ثبت رای را انتخاب کنید." ));
            }
        }


        mysqli_close($conn);


    }


    public function GenerateIK($btn_number, $btn_nr, $btn_texts, $btn_ids)
    {

        $n = ceil($btn_number / $btn_nr);
        $IK = array();
        for ($i = 0, $k = 0; $i < $n; $i++) {
            for ($j = 0; $k < $btn_number && $j < $btn_nr; $j++, $k++) {
                $IK[$i][$j]['text'] = $btn_texts[$k];
                $IK[$i][$j]['callback_data'] = $btn_ids[$k];
            }
        }


        // $IK[$n][0]['text'] = "به اشتراک گذاری";
        // $IK[$n][0]['switch_inline_query'] = $poll_id;

        return $IK;

    }


}

class twitterbot extends telegrambot
{

    public $users_table = 'uut_members';
    public $favtweets_table = 'uut_favtweets';
    public $likes_table = 'uut_likes';


    public function GetStep($id)
    {

        $conn = $this->CreateConn();

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());

        }


        $sql = "SELECT step FROM $this->users_table where telegram = '$id' ";

        $result = $conn->query($sql);


        $row = $result->fetch_assoc();


        $selected = $row["step"];

        //ta inja ok


        mysqli_close($conn);
        return $selected;
    }

    public function UpdateStep($id, $step)
    {

        $conn = $this->CreateConn();

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        //safe sazi
        $step = mysqli_real_escape_string($conn, $step);

        $conn->query("UPDATE $this->users_table SET step = '$step' where telegram = '$id'");


        mysqli_close($conn);
    }

    public function UpdateField($id, $field)
    {

        $conn = $this->CreateConn();

        // Check connection


        //safe sazi
        $field = mysqli_real_escape_string($conn, $field);

        $conn->query("UPDATE $this->users_table SET field = '$field' where telegram = '$id'");


        mysqli_close($conn);
    }


    public function InsertUserInDBifNE($id, $fname, $lname, $username, $step)
    {

        $conn = $this->CreateConn();

        // Check connection


        //add if not exist
        $sql = "SELECT * FROM $this->users_table where telegram = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return true;
        } else {
            $username = mysqli_real_escape_string($conn, $username);

            $fname = mysqli_real_escape_string($conn, $fname);
            //$lname = mysqli_real_escape_string($conn, $lname);
            $conn->query("INSERT into $this->users_table (telegram,firstname,username,step ) VALUES ('$id','$fname','$username','$step')");
        }

        mysqli_close($conn);

    }

    public function InsertFavifNE($message_id)
    {

        $conn = $this->CreateConn();

        // Check connection

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        //add if not exist
        $sql = "SELECT * FROM $this->favtweets_table where message_id = '$message_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            //apiRequest("sendMessage", array('chat_id' => $id,'text'=>"این توییت قبلا در لیست محبوب ها ثبت شده" ));

            mysqli_close($conn);
            return false;
        } else {
            $sql = "INSERT INTO $this->favtweets_table VALUES ('$message_id')";
            $result = $conn->query($sql);
            if ($result) {
                mysqli_close($conn);
                return true;
            } else {
                //  apiRequest("sendMessage", array('chat_id' => $id,'text'=>"خطا در ثبت توییت. لطفا بعدا تلاش کنید." ));
                mysqli_close($conn);
                return false;
            }
        }


        mysqli_close($conn);


    }

    public function DeleteFav($message_id)
    {

        $conn = $this->CreateConn();

        // Check connection

        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        //add if not exist
        $sql = "SELECT * FROM $this->favtweets_table where message_id = '$message_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            if ($conn->query("DELETE FROM $this->favtweets_table where message_id = '$message_id'")) {
                mysqli_close($conn);
                return true;
            } else {
                //apiRequest("sendMessage", array('chat_id' => $id,'text'=>"خطا در حذف" ));
                mysqli_close($conn);
                return false;
            }

        } else {
            //apiRequest("sendMessage", array('chat_id' => $id,'text'=>"خطا در حذفف" ));

            mysqli_close($conn);
            return false;
        }


        mysqli_close($conn);


    }


    function SelectLastNfromDB($column, $table, $n)
    {

        $conn = $this->CreateConn();

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        $sql = "SELECT $column FROM (
	SELECT $column FROM $table ORDER BY $column DESC LIMIT $n)sub
	ORDER BY $column ASC ";
        //$sql = "SELECT $column FROM $table ORDER BY $column DESC LIMIT $n ";
        $result = $conn->query($sql);
        $i = 0;
        $selected = array();
        while ($row = $result->fetch_assoc()) {
            $selected[$i] = $row[$column];
            $i++;
        }

        mysqli_close($conn);
        return $selected;
    }

    public function HasNickName($id)
    {

        $conn = $this->CreateConn();

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        //add if not exist
        $sql = "SELECT nickname FROM $this->users_table where telegram = '$id'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            if ($result->fetch_assoc()['nickname'] == null)
                return false;
            return true;

        } else {
            return false;
        }

        mysqli_close($conn);

    }


    public function IsThisUnique($nickname)
    {

        $conn = $this->CreateConn();

        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $nickname = mysqli_real_escape_string($conn, $nickname);
        //add if not exist
        $sql = "SELECT nickname FROM $this->users_table where nickname = '$nickname'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            mysqli_close($conn);
            return false;
        } else {
            mysqli_close($conn);
            return true;
        }


    }

    public function PersianEnglishWithoutSpace($text)
    {
        if (preg_match("/^[a-zA-Z0-9\x{0600}-\x{06FF}_]+$/u", $text))
            return true;
        else
            return false;
    }


    public function ShowProfile($id, $K_Profile)
    {
        $this->UpdateStep($id, "profile");

        $record = $this->SelectRecordfromDB($id, $this->users_table);
        $nickname = $record['nickname'];
        $field = $record['field'];
        $this->SendMK($id, $K_Profile, "مشخصات شما 👤

اسم مستعار : $nickname
نام رشته  : $field

💡پر کردن فیلد اسم مستعار برای گذاشتن توییت لازمه و بصورت هشتگ زیر توییت هاتون زده میشه.
💡پر کردن فیلد نام رشته تون اختیاریه و برا قشنگی پروفایلتونه ولی خدا رو چه دیدی شاید یه شغل خوب برات پیدا کردم😇.");
    }


    //like
    public function CountLDs($message_id)
    {

        $conn = $this->CreateConn();
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        $result = $conn->query("SELECT COUNT(btn_id) AS likes FROM $this->likes_table where btn_id = 'L' AND message_id = '$message_id'  ");
        if ($result->num_rows > 0)
            $votes['likes'] = $result->fetch_assoc()['likes'];

        $result = $conn->query("SELECT COUNT(btn_id) AS dislikes FROM $this->likes_table where btn_id = 'D' AND message_id = '$message_id'  ");

        if ($result->num_rows > 0)
            $votes['dislikes'] = $result->fetch_assoc()['dislikes'];

        mysqli_close($conn);
        return $votes;
    }

    public function CountVotes($message_id)
    {
        $total = 1;

        $conn = $this->CreateConn();

        $result = $conn->query("SELECT COUNT(message_id) AS total FROM $this->likes_table where message_id = '$message_id'  ");

        if ($result->num_rows > 0)
            $total = $result->fetch_assoc()['total'];


        mysqli_close($conn);
        return $total;
    }


    public function LoadIK($messaage_id)
    {


        $btn_votes = $this->CountLDs($messaage_id);
        $Total = $this->CountVotes($messaage_id); //ok
        $IK =
            [
                [
                    ['text' => " 👎" . round(($btn_votes['dislikes'] / $Total * 100), 2) . "% (" . $btn_votes['dislikes'] . ")", 'callback_data' => "D"],
                    ['text' => " 👍" . round(($btn_votes['likes'] / $Total * 100), 2) . "% (" . $btn_votes['likes'] . ")", 'callback_data' => "L"],
                ]
            ];


        return $IK;

    }


    public function SubmitOrRemoveVote($id, $btn_id, $message_id)
    {
        $conn = $this->CreateConn();


        $already_voted_on_this = false;


        $result = $conn->query("SELECT btn_id FROM $this->likes_table where telegram = '$id' AND message_id = '$message_id'");
        if ($result->num_rows > 0) //voted
        {
            $row = $result->fetch_assoc();
            if ($btn_id == $row["btn_id"]) { //voted on this
                $already_voted_on_this = true;
                $conn->query("DELETE FROM $this->likes_table where btn_id = '$btn_id' AND telegram = '$id' AND message_id = '$message_id'");
            }
        } else { //not voted yet
            $conn->query("INSERT INTO $this->likes_table ( telegram, btn_id , message_id) VALUES ('$id','$btn_id', '$message_id')");
            mysqli_close($conn);
            return 1;
        }

        //check vote existence
        if ($already_voted_on_this) {
            //$conn->query("DELETE FROM $this->ldea_likes where btn_id = '$btn_id' AND telegram = '$id' AND message_id = '$message_id'");
            mysqli_close($conn);
            return -1;
        } else //voted on other btn
        {
            if ($btn_id == "L")
                $votedbtn_id = "D";
            else {
                $votedbtn_id = "L";
            }

            if (isset($votedbtn_id)) //voted on other btns
            {
                $conn->query("DELETE FROM $this->likes_table where btn_id = '$votedbtn_id' AND telegram = '$id' AND message_id = '$message_id'");
                $conn->query("INSERT INTO $this->likes_table ( telegram, btn_id,message_id) VALUES ('$id','$btn_id','$message_id')");
                mysqli_close($conn);
                return 0;
            }

        }


        mysqli_close($conn);
        return null;

    }


    // f like
    public function Greeting()
    {
        date_default_timezone_set('Asia/Tehran');

        $greet = "سلام";
        $h = date('H');
        if ($h > 4 && $h < 10) {
            $greet = "سلام صبح بخیر";
        }
        if ($h >= 10 && $h < 12) {
            $greet = "سلام روزتون بخير و خوشي";
        }
        if ($h >= 12 && $h < 15) {
            $greet = "سلام ظهر دانشجوییت بخير";
        }
        if ($h >= 15 && $h < 17) {
            $greet = "سلام بعد از ظهرتون بخير";
        }
        if ($h >= 17 && $h < 19) {
            $greet = "سلام عصرتون بخير";
        }
        if ($h >= 19 && $h < 24) {
            $greet = "سلام شبتون بخير و خوشي";
        }
        if ($h >= 0 && $h <= 4) {
            $greet = "سلام😦. آغا من شرمندم این رفیقمون گیر داده نصف شبی منو بهتون معرفی کنه ";
        }

        return $greet;
    }


    /*
     *
     * if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
     */
}
