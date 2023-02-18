<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductColorRequest extends FormRequest
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
            'color_id' => 'required|exists:colors,id',
            'price_increase' => 'required|numeric',
            'marketable_number' => 'required|numeric',
            'frozen_number' => 'required|numeric',
            'sold_number' => 'required|numeric',
            'status' => 'required|numeric|in:0,1',
        ];
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        return [

        ];
    }
}
