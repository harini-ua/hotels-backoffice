<?php

namespace App\Http\Controllers;

use App\DataTables\AdminsDataTable;
use App\DataTables\BookingUsersDataTable;
use App\Enums\UserRole;
use App\Http\Requests\AdminStoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param BookingUsersDataTable $dataTable
     * @return mixed
     */
    public function index(AdminsDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('List Admin Users')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Admins')]
        ];

        $actions = [
            ['href' => route('admins.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        return $dataTable->render('admin.pages.admins.index', compact(
            'breadcrumbs',
            'actions'
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
            ['title' => __('Create Admin')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('admins.index'), 'name' => __('Admins')],
            ['name' => __('Create')]
        ];

        return view('admin.pages.admins.create', compact('breadcrumbs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdminStoreRequest $request
     * @return RedirectResponse
     */
    public function store(AdminStoreRequest $request)
    {
        $user = new User();
        $user->fill($request->except('password'));
        $user->password = Hash::make($request->get('password'));
        $user->save();

        $user->assignRole(UserRole::ADMIN);

        alert()->success($user->fullname, __('Admin created has been successful.'));

        return redirect()->route('admins.index');
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

    /**
     * Get QR code.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function qr(User $user)
    {
        try {
            $qr = (string) QrCode::size(250)->generate($user->fullname);

            return response()->json(['success' => true, 'qr' => $qr]);
        } catch (\PDOException $e) {
            return response()->json(['success' => false]);
        }
    }
}
