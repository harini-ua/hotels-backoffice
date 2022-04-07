<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserStoreRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Distributor;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
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

        $companies = Company::all()
            ->sortBy('name')
            ->where('status', 1)
            ->pluck('name', 'id');

        return $dataTable->render('admin.pages.users.index', compact(
            'breadcrumbs' ,'actions', 'companies'
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
        $user = new User();
        $user->fill($request->except('password', 'invoice_allowed', 'send_to_email'));
        $user->password = Hash::make($request->get('password'));
        $user->save();

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        $breadcrumbs = [
            ['title' => $user->fullname],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('users.index'), 'name' => __('Users')],
            ['name' => __('Show User')]
        ];

        return view('admin.pages.users.show', compact(
            'breadcrumbs', 'user'
        ));
    }

    public function passwordChange(Request $request, User $user)
    {
        $success = false;

        if ($request->has('password')) {
            $success = $user->update([
                'password' => \Hash::make($request->get('password'))
            ]);
        }

        return response()->json([
            'success' => $success
        ]);
    }

    public function passwordSend(User $user)
    {
        //TODO: Need implement sent user password

        return response()->json([
            'success' => true
        ]);
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
