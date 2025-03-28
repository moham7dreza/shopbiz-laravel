<?php

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $route = Route::current();
        if ($route->getName() === 'product.tags.sync') {
            return [
                'tags.*' => 'exists:tags,id'
            ];
        }
        if ($route->getName() === 'product.values.sync') {
            return [
                'values.*' => 'exists:attribute_values,id'
            ];
        }
        $rules = [
            'name' => 'required|max:1120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'introduction' => 'required|max:1000|min:5',
            'weight' => 'required|max:1000|min:1|numeric',
            'length' => 'required|max:1000|min:1|numeric',
            'width' => 'required|max:1000|min:1|numeric',
            'height' => 'required|max:1000|min:1|numeric',
            'price' => 'required|numeric',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif',
            'status' => 'required|numeric|in:0,1',
            'marketable' => 'required|numeric|in:0,1',
            'category_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:product_categories,id',
            'brand_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:brands,id',
            'published_at' => 'required|numeric',
            'meta_key.*' => 'required',
            'meta_value.*' => 'required',
        ];

        if (!$this->isMethod('post')) {
            $rules['image'] = 'image|mimes:png,jpg,jpeg,gif';
        }
        return $rules;
    }
}
