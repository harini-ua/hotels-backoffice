<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function profile()
    {
        $breadcrumbs = [
            ['title' => __('My Profile')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('My Profile')]
        ];

        /** @var User $user */
        $user = \Auth::user();

        $lastLogin = __('Never');
        if ($user->last_login_at) {
            $lastLogin = $user->last_login_at->format(config('admin.dateformat'));
            $forHumans = __($user->last_login_at->diffForHumans());
            $lastLogin .= " ($forHumans)";
        }

        $canEdit = $user->hasPermissionTo('edit profile');

        return view('admin.pages.profile', compact(
            'breadcrumbs', 'user', 'lastLogin', 'canEdit'
        ));
    }
}
