<?php

namespace Modules\Cart\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
            'color' => 'nullable|exists:product_colors,id',
            'guarantee' => 'nullable|exists:guarantees,id',
            'number' => 'numeric|min:1|max:5'
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [

        ];
    }
}
