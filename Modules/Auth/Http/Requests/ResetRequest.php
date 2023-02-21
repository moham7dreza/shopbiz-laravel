<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ResetRequest extends FormRequest
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
        $route = Route::current();
        if ($route->getName() == 'auth.reset-password') {
            return [
                'email' => 'required|email|min:3|max:190|exists:users,email',
            ];
        } elseif ($route->getName() == 'auth.verify-password') {
            return [
                'email' => 'required|email|exists:users,email',
                'token' => 'required',
                'password' => 'required|string|min:6|max:255|confirmed',
            ];
        }

    }
}
