<?php

namespace Modules\Notify\Http\Controllers;


use Modules\Notify\Entities\Notification;
use Modules\Share\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function readAll(){
       $notifications = Notification::all();
       foreach($notifications as $notification){
           $notification->update(['read_at' => now()]);
       }
    }
}
