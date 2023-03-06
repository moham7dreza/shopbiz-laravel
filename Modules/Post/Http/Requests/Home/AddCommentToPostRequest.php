<?php

namespace Modules\Post\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;

class AddCommentToPostRequest extends FormRequest
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
            'body' => 'required|max:2000'
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
