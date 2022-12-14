<?php

namespace App\Http\Controllers;

use App\DataTables\BookingUsersDataTable;
use App\Enums\UserRole;
use App\Http\Requests\BookingUserStoreRequest;
use App\Models\BookingUser;
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
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class BookingUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BookingUsersDataTable $dataTable
     * @return mixed
     */
    public function index(BookingUsersDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('List Booking Users')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('users.index'), 'name' => __('Users')],
            ['name' => __('Booking Users')]
        ];

        $actions = [
            ['href' => route('booking-users.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $companies = Company::all()
            ->sortBy('name')
            ->where('status', 1)
            ->pluck('company_name', 'id');

        return $dataTable->render('admin.pages.booking-users.index', compact(
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
            ['link' => route('users.index'), 'name' => __('Users')],
            ['link' => route('booking-users.index'), 'name' => __('Booking Users')],
            ['name' => __('Create')]
        ];

        $distributors = Distributor::all()
            ->where('status', 1)
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

        return view('admin.pages.booking-users.create', compact(
            'breadcrumbs',
            'distributors',
            'countries',
            'languages'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BookingUserStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(BookingUserStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $company = Company::findOrFail($request->get('company_id'));

            $bookingUser = new BookingUser();
            $bookingUser->fill($request->except('password', 'invoice_allowed', 'send_to_email'));
            $bookingUser->username = $bookingUser->email;
            $bookingUser->password = Hash::make($request->get('password'));
            $bookingUser->save();

            $company->bookingUsers()->attach($bookingUser);

            $bookingUser->assignRole(UserRole::BOOKING);

            if ($request->has('invoice_allowed')) {
                $bookingUser->givePermissionTo('invoice allowed');
            }

            if ($request->has('send_to_email')) {
                // TODO: Implement send login details to email.
            }

            DB::commit();

            alert()->success($bookingUser->fullname, __('User created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('booking-users.index');
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
            ['link' => route('booking-users.index'), 'name' => __('Booking Users')],
            ['name' => __('Show')]
        ];

        return view('admin.pages.booking-users.show', compact(
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
