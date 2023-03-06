<?php

namespace Modules\Auth\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Auth\Http\Requests\LoginRequest;
use Modules\Share\Http\Controllers\Controller;

class ApiLoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::validate($credentials)) {
            return response()->json(['message' => 'ایمیل و رمز عبور با یکدیگر مطابقت ندارند.',
                'status' => 'error',
                'data' => null]);
        }
        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        Auth::login($user);
        return response()->json(['message' => 'با موفقیت وارد شدید',
            'status' => 'success',
            'data' => null]);
    }
}
