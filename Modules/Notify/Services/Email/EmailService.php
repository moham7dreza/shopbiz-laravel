<?php

namespace Modules\Notify\Services\Email;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Entities\Email;
use Modules\Share\Services\ShareService;

class EmailService implements EmailServiceInterface
{
    /**
     * @param $request
     * @return Builder|Model
     */
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'subject' => $request->subject,
            'body' => $request->body,
            'status' => $request->status,
            'published_at' => ShareService::realTimestampDateFormat($request->published_at),
        ]);
    }

    /**
     * @param $request
     * @param $email
     * @return mixed
     */
    public function update($request, $email): mixed
    {
        return $email->update([
            'subject' => $request->subject,
            'body' => $request->body,
            'status' => $request->status,
            'published_at' => ShareService::realTimestampDateFormat($request->published_at),
        ]);
    }

    /**
     * Get product query (builder).
     *
     * @return Builder
     */
    private function query(): Builder
    {
        return Email::query();
    }
}
