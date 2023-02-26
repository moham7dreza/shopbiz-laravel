<?php

namespace Modules\Contact\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Contact\Entities\Contact;
use Modules\Contact\Notifications\NewContactRegistered;
use Modules\Share\Services\ShareService;

class ContactService
{
    /**
     * @param $request
     * @param string $type
     * @return Builder|Model
     */
    public function store($request, string $type = 'meet'): Model|Builder
    {
        return $this->query()->create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $type == 'meet' ? $request->subject : null,
            'message' => $request->message,
            'meet_date' => $type == 'meet' ? ShareService::realTimestampDateFormat($request->meet_date) : null,
            'is_read' => Contact::NOT_READ,
            'approved' => Contact::NOT_APPROVED,
            'status' => Contact::STATUS_INACTIVE,
        ]);
    }

    /**
     * @param $adminUser
     * @param $contactId
     * @param string $type
     * @return void
     */
    public function sendContactCreatedNotificationToAdmin($adminUser, $contactId, string $type = 'meet'): void
    {
        $details = [
            'message' => $type == 'contact' ? 'یک فرم ارتباط با مای جدید ثبت شد.' : 'یک قرار ملاقات جدید ثبت شد.',
            'contact_id' => $contactId,
        ];
        $adminUser->notify(new NewContactRegistered($details));
    }

    /**
     * @return Builder
     */
    private function query(): Builder
    {
        return Contact::query();
    }
}
