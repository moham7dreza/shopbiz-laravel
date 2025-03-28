<?php

namespace Modules\Brand\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class BrandRequest extends FormRequest
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
        if ($route->getName() === 'brand.tags.sync') {
            return [
                'tags.*' => 'exists:tags,id'
            ];
        }
        $rules = [
            'original_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'persian_name' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
            'logo' => 'required|image|mimes:png,jpg,jpeg,gif',
            'status' => 'required|numeric|in:0,1',
        ];
        if (!$this->isMethod('post')) {
            $rules['logo'] = 'image|mimes:png,jpg,jpeg,gif';
        }
        return $rules;
    }
}
