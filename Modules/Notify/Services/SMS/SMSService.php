<?php

namespace Modules\Notify\Services\SMS;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Notify\Entities\SMS;
use Modules\Share\Services\ShareService;

class SMSService implements SMSServiceInterface
{

    /**
     * @param $request
     * @return Builder|Model
     */
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'title' => $request->title,
            'body' => $request->body,
            'status' => $request->status,
            'published_at' => ShareService::realTimestampDateFormat($request->published_at),
        ]);
    }

    /**
     * @param $request
     * @param $sms
     * @return mixed
     */
    public function update($request, $sms): mixed
    {
        return $sms->update([
            'title' => $request->title,
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
        return SMS::query();
    }
}
