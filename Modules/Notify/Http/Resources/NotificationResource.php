<?php

namespace Modules\Notify\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message' => 'داده های مربوطه به اعلانات',
            'status' => 'success',
            'count' => count($this->collection),
            'data' => $this->collection->map(function ($notification) {
                return [
                    'notify_send_to' => $notification->notifiable_type::findOrFail($notification->notifiable_id)->fullName,
                    'notify_data' => $notification->data['message'],
                    'notify_created_date' => jalaliDate($notification->created_at),
                ];
            }),
        ];
    }
}
