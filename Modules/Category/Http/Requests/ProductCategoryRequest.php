<?php

namespace Modules\Category\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ProductCategoryRequest extends FormRequest
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
        if ($route->getName() === 'productCategory.tags.sync') {
            return [
                'tags.*' => 'exists:tags,id'
            ];
        }
        $rules = [
            'name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif',
            'status' => 'required|numeric|in:0,1',
            'show_in_menu' => 'required|numeric|in:0,1',
            'parent_id' => 'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:product_categories,id',
        ];
        if (!$this->isMethod('post')) {
            $rules['image'] = 'image|mimes:png,jpg,jpeg,gif';
        }
        return $rules;
    }
}
