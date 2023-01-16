<?php

namespace Modules\Delivery\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'amount' => 'required|regex:/^[0-9]+$/u',
            'delivery_time' => 'required|integer',
            'delivery_time_unit' => 'required|regex:/^[ا-یa-zA-Zء-ي., ]+$/u',
            'status' => 'required|in:0,1'
        ];
    }
}
