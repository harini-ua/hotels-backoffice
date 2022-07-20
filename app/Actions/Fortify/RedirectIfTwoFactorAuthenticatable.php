<?php

namespace App\Actions\Fortify;

use App\Models\IpFilter;
use Illuminate\Support\Facades\App;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable as DefaultRedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\TwoFactorAuthenticatable;

class RedirectIfTwoFactorAuthenticatable extends DefaultRedirectIfTwoFactorAuthenticatable
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  callable  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        $user = $this->validateCredentials($request);

        if (optional($user)->two_factor_secret &&
            in_array(TwoFactorAuthenticatable::class, class_uses_recursive($user)) &&
            $this->checkIfUserHasWhiteIp($request, $user)) {
            return $this->twoFactorChallengeResponse($request, $user);
        }

        return $next($request);
    }

    /**
     * This checks if the user has a whitelisted ip address in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return bool
     */
    protected function checkIfUserHasWhiteIp($request, $user)
    {
        $whiteIps = IpFilter::all()->pluck('ip_address')->toArray();

        return !(App::environment('local') || in_array($request->ip(), $whiteIps, true));
    }
}
