<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CheckDeactivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User $user */
        $user = auth()->user();

        if ($user) {
            $created = Carbon::parse($user->created_at);
            $lastLogin = Carbon::parse($user->last_login_at);

            $days = config('admin.account.deactivation_in_days');

            if ($days && $created->diffInDays($lastLogin) >= $days) {
                auth()->logout();

                return redirect()->route('login')
                    ->withMessage(__('This account has been deactivated!'));
            }
        }

        return $next($request);
    }
}
