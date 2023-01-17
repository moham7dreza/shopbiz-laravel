<?php

namespace Modules\Address\Services;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Modules\Address\Entities\Address;

class AddressService
{
    /**
     * @param $request
     * @return Builder|Model
     */
    public function store($request): Model|Builder
    {
        return $this->query()->create([
            'user_id' => auth()->id(),
            'city_id' => $request->city_id,
            'address' => $request->address,
            'postal_code' => $this->convertToEnglish($request->postal_code),
            'no' => $request->no,
            'unit' => $request->unit,
            'recipient_first_name' => $this->checkReceiver($request->receiver, $request->recipient_first_name),
            'recipient_last_name' => $this->checkReceiver($request->receiver, $request->recipient_last_name),
            'mobile' => $this->checkReceiver($request->receiver, $request->mobile),
        ]);
    }

    /**
     * @param $request
     * @param $address
     * @return mixed
     */
    public function update($request, $address): mixed
    {
        return $address->update([
            'user_id' => auth()->id(),
            'city_id' => $request->city_id,
            'address' => $request->address,
            'postal_code' => $this->convertToEnglish($request->postal_code),
            'no' => $request->no,
            'unit' => $request->unit,
            'recipient_first_name' => $this->checkReceiver($request->receiver, $request->recipient_first_name),
            'recipient_last_name' => $this->checkReceiver($request->receiver, $request->recipient_last_name),
            'mobile' => $this->checkReceiver($request->receiver, $request->mobile)
        ]);
    }

    private function checkReceiver($status, $field)
    {
        return $status === "on" ? $field : null;
    }

    /**
     * @param $number
     * @return array|string
     */
    private function convertToEnglish($number): array|string
    {
        $number = convertArabicToEnglish($number);
        return convertPersianToEnglish($number);
    }

    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Address::query();
    }
}
