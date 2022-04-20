<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UserStoreRequest;
use App\Models\Company;
use App\Models\Country;
use App\Models\Distributor;
use App\Models\Language;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class BookingUserController extends Controller
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
            ['title' => __('List Booking Users')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Users')]
        ];

        $actions = [
            ['href' => route('users.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $companies = Company::all()
            ->sortBy('name')
            ->where('status', 1)
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.users.index', compact(
            'breadcrumbs',
            'actions',
            'companies'
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
            ['title' => __('Create Booking User')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('users.index'), 'name' => __('Booking Users')],
            ['name' => __('Create')]
        ];

        $distributors = Distributor::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $companies = Company::all()
            ->where('status', 1)
            ->sortBy('company_name')
            ->pluck('company_name', 'id');

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        $languages = Language::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return view('admin.pages.users.create', compact(
            'breadcrumbs',
            'distributors',
            'companies',
            'countries',
            'languages'
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
        $user->username = $user->email;
        $user->password = Hash::make($request->get('password'));
        $user->save();

        $user->assignRole('employee');

        if ($request->has('invoice_allowed')) {
            $user->givePermissionTo('invoice allowed');
        }

        if ($request->has('send_to_email')) {
            // TODO: Implement send login details to email.
        }

        alert()->success($user->fullname, __('Distributor created has been successful.'));

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
            ['link' => route('users.index'), 'name' => __('Booking Users')],
            ['name' => __('Show')]
        ];

        return view('admin.pages.users.show', compact(
            'breadcrumbs',
            'user'
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
