<?php

namespace Modules\Notify\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmailFileRequest extends FormRequest
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
        $rules = [
            'file' => 'required|mimes:png,jpg,jpeg,gif,zip,pdf,docx,doc',
            'status' => 'required|numeric|in:0,1',
        ];
        if (!$this->isMethod('post')) {
            $rules['file'] = 'mimes:png,jpg,jpeg,gif,zip,pdf,docx,doc';
        }
        return $rules;
    }
}
