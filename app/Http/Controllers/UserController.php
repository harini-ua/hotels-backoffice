<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserStoreRequest;
use App\Models\Country;
use App\Models\Distributor;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

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
            ['title' => __('List Users')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Users')]
        ];

        $actions = [
            ['href' => route('users.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return $dataTable->render('admin.pages.users.index', compact(
            'breadcrumbs' ,'actions'
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

    /**
     * Show the form for creating a new resource.
     *
     * @return Response|View
     */
    public function create()
    {
        $breadcrumbs = [
            ['title' => __('Create User')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('users.index'), 'name' => __('Users')],
            ['name' => __('Create')]
        ];

        $distributors = Distributor::all()
            ->sortBy('name')
            ->pluck('name', 'id');

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.users.create', compact(
            'breadcrumbs', 'distributors', 'countries', 'languages'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request)
    {
        /** @var User $user */
        $user = User::create($request->all());
        $user->assignRole('employee');

        if ($request->has('invoice_allowed')) {
            $user->givePermissionTo('invoice allowed');
        }

        if ($request->has('send_to_email')) {
            // TODO: Implement send login details to email.
        }

        return redirect()->route('admin.pages.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
