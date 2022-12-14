<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::loginView(function () {
            return view('admin.auth.login');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('admin.auth.passwords.email');
        });

        Fortify::resetPasswordView(function () {
            return view('admin.auth.passwords.reset');
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();
            if ($user && $user->active &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        Fortify::loginThrough(function ($request) {
            return [
                \App\Actions\Fortify\RedirectIfTwoFactorAuthenticatable::class,
                \Laravel\Fortify\Actions\AttemptToAuthenticate::class,
                \Laravel\Fortify\Actions\PrepareAuthenticatedSession::class,
            ];
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(10)->by($request->session()->get('login.id'));
        });

        Fortify::confirmPasswordView(function () {
            return view('admin.auth.passwords.confirm');
        });

        Fortify::twoFactorChallengeView(function () {
            return view('admin.auth.two-factor');
        });
    }
}
