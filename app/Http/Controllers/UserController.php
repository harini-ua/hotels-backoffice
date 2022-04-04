<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UsersDataTable $dataTable
     * @return mixed
     */
    public function index(UsersDataTable $dataTable)
    {
        $breadcrumbs = [
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Users')]
        ];

        return $dataTable->render('admin.pages.users.index', compact(
            'breadcrumbs'
        ));
    }

    public function profile()
    {
        $breadcrumbs = [
            ['title' => __('My Profile')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('My Profile')]
        ];

        /** @var User $user */
        $user = \Auth::user();
        $canEdit = $user->hasPermissionTo('edit profile');

        return view('admin.pages.profile', compact(
            'breadcrumbs', 'user', 'canEdit'
        ));
    }
}
