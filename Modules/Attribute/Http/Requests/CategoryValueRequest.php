<?php

namespace Modules\Attribute\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryValueRequest extends FormRequest
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
            'value' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'price_increase' => 'required|numeric',
            'type' => 'required|numeric|in:0,1',
            'product_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:products,id',
        ];
    }
}
