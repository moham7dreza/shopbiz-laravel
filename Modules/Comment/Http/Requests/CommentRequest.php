<?php

namespace Modules\Comment\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
        return [
            'body' => 'required|min:2|max:1000|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u'
        ];
    }
}
