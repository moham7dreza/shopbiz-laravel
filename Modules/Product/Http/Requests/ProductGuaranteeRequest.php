<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductGuaranteeRequest extends FormRequest
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
            'guarantee_id' => 'required|exists:guarantees,id',
            'duration' => 'required',
            'price_increase' => 'required|numeric',
            'status' => 'required|numeric|in:0,1',
        ];
    }
}
