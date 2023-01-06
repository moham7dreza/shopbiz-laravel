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
        return auth()->check() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $route = Route::current();
        if ($route->getName() === 'role.store') {
            return [
                'name' => 'required|max:120|min:1',
                'description' => 'required|max:200|min:1',
                'permissions.*' => 'exists:permissions,id'
            ];
        } elseif ($route->getName() === 'role.update') {
            return [
                'name' => 'required|max:120|min:1',
                'description' => 'required|max:200|min:1',
            ];
        } elseif ($route->getName() === 'role.permission-update') {
            return [
                'permissions.*' => 'exists:permissions,id'
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
