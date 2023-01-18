<?php

namespace Modules\Home\Http\Middlewares;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        if (!empty($user->email) && empty($user->mobile) && empty($user->email_verified_at)) {
            return redirect()->route('customer.sales-process.profile-completion');
        }

        if (empty($user->first_name) || empty($user->last_name) || empty($user->national_code)) {
            return redirect()->route('customer.sales-process.profile-completion');
        }

        if (!empty($user->mobile) && empty($user->email) && empty($user->mobile_verified_at)) {
            return redirect()->route('customer.sales-process.profile-completion');
        }

        return $next($request);
    }
}
