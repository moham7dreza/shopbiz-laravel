<?php

namespace Modules\Attribute\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class AttributeRequest extends FormRequest
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
        $route = Route::current();
        if ($route->getName() === 'attribute.category-update') {
            return [
                'categories.*' => 'exists:product_categories,id'
            ];
        } else {
            return [
                'name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'name_en' => 'nullable|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'unit' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'unit_en' => 'nullable|max:120|min:1|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'type' => 'required|numeric|in:0,1',
//            'category_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:product_categories,id',
                'status' => 'required|in:0,1'
            ];
        }
    }
}
