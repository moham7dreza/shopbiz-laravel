<?php

namespace Modules\User\Http\Requests\Home;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class StoreTicketRequest extends FormRequest
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
        if ($route->getName() === 'customer.profile.my-tickets.answer') {
            return [
                'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي?؟.,><\/;\n\r& ]+$/u',
            ];
        } else {
            return [
                'subject' => 'required|max:120|min:2|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي., ]+$/u',
                'description' => 'required|max:500|min:5|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي?؟.,><\/;\n\r& ]+$/u',
                'file' => 'nullable|mimes:png,jpg,jpeg,gif,zip,pdf,docx,doc',
                'category_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:ticket_categories,id',
                'priority_id' => 'required|min:1|max:100000000|regex:/^[0-9]+$/u|exists:ticket_priorities,id',
            ];
        }
    }
}
