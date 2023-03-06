<?php

namespace Modules\ACL\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class RoleRequest extends FormRequest
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
        if ($route->getName() === 'role.permission-update') {
            return [
                'permissions.*' => 'exists:permissions,id'
            ];
        } else {
            return [
                'name' => 'required|max:120|min:1',
                'description' => 'nullable|max:200|min:1',
                'status' => 'required|in:0,1',
            ];
        }
    }

    public function attributes(): array
    {

        return [
            'name' => 'عنوان نقش',
            'permissions.*' => 'دسترسی'
        ];
    }
}
