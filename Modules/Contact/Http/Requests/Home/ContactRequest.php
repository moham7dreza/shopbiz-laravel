<?php

namespace Modules\Contact\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'first_name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
            'last_name' => 'required|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
            'phone' => ['required', 'digits:11'],
            'email' => ['required', 'string', 'email'],
            'subject' => 'nullable|max:120|min:1|regex:/^[ا-یa-zA-Zء-ي ]+$/u',
            'message' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي?؟.,><\/;\n\r& ]+$/u',
            'file' => 'nullable|mimes:png,jpg,jpeg,gif,zip,pdf,docx,doc',
            'meet_date' => 'nullable|numeric',
        ];
        if (Route::current()->getName() === 'customer.pages.make-appointment.submit') {
                $rules['meet_date'] = 'required|numeric';
        }
        return $rules;
    }
}
