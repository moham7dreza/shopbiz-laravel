<?php

namespace Modules\Page\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class PageRequest extends FormRequest
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
        if ($route->getName() === 'page.tags.sync') {
            return [
                'tags.*' => 'exists:tags,id'
            ];
        }
        return [
            'title' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
//            'body' => 'required|max:1000|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><\/;\n\r& ]+$/u',
            'body' => 'required',
            'status' => 'required|numeric|in:0,1',
        ];
    }
}
