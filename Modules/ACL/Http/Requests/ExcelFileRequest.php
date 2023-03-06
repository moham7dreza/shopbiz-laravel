<?php

namespace Modules\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExcelFileRequest extends FormRequest
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
            'file' => 'required|mimes:png,jpg,jpeg,gif,zip,pdf,docx,doc,xlsx,csv',
        ];
    }
}
