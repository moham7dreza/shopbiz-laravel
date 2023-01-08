<?php

namespace Modules\Home\Http\Requests\SalesProcess;

use Illuminate\Foundation\Http\FormRequest;
use Modules\User\Rules\PostalCode;

class UpdateAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'address' => 'required|min:1|max:300',
            'postal_code' => ['required', new PostalCode()],
            'no' => 'required',
            'unit' => 'required',
            'receiver' => 'sometimes',
            'recipient_first_name' => 'required_with:receiver,on',
            'recipient_last_name' => 'required_with:receiver,on',
            'mobile' => 'required_with:receiver,on',
        ];
    }

    public function attributes(): array
    {
        return [
            'unit' => 'واحد',
            'mobile' => 'موبایل گیرنده',
        ];
    }
}
