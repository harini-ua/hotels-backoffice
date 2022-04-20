<?php

namespace App\Http\Controllers;

use App\DataTables\DistributorUsersDataTable;
use App\Http\Requests\DistributorUserStoreRequest;
use App\Http\Requests\DistributorUserUpdateRequest;
use App\Models\Distributor;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class DistributorUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param DistributorUsersDataTable $dataTable
     * @return mixed
     */
    public function index(DistributorUsersDataTable $dataTable)
    {
        $breadcrumbs = [
            ['title' => __('list Distributor Users')],
            ['link' => route('home'), 'name' => __('Home')],
            ['name' => __('Users')]
        ];

        $actions = [
            ['href' => route('distributors.users.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $distributors = Distributor::all()
            ->where('status', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return $dataTable->render('admin.pages.distributor-users.index', compact(
            'breadcrumbs',
            'actions',
            'distributors'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response|View
     */
    public function create(Distributor $distributor = null)
    {
        $breadcrumbs = [
            ['title' => __('Create Distributor User')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('distributors.index'), 'name' => __('Distributors User')],
            ['name' => __('Create User')]
        ];

        if (!$distributor) {
            if ((\Auth::user())->hasRole('admin')) {
                $distributor = Distributor::all()
                    ->where('status', 1)
                    ->sortBy('name')
                    ->pluck('name', 'id');
            } else {
                $distributor = (\Auth::user())->distributors()->where('status', true)->first();
            }
        }

        return view('admin.pages.distributor-users.create', compact(
            'breadcrumbs',
            'distributor'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param DistributorUserStoreRequest $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(DistributorUserStoreRequest $request)
    {
        try {
            DB::beginTransaction();

            $distributor = Distributor::findOrFail($request->get('distributor'));

            $user = new User();
            $user->fill($request->except('distributor'));
            $user->password = Hash::make($request->get('password'));
            $user->save();

            $user->distributors()->attach($distributor);

            $user->assignRole('distributor');

            DB::commit();

            alert()->success($user->fullname, __('User created has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('distributors.users.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user)
    {
        $breadcrumbs = [
            ['title' => __('Update Distributor User')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('distributors.users.index'), 'name' => __('Distributors Users')],
            ['name' => $user->fullname]
        ];

        $distributor = (\Auth::user())->hasRole('admin') ?
            Distributor::all()
                ->where('status', 1)
                ->sortBy('name')
                ->pluck('name', 'id')
            :
            (\Auth::user())->distributors()->where('status', true)->first()
        ;

        return view('admin.pages.distributor-users.update', compact(
            'breadcrumbs',
            'user',
            'distributor'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param DistributorUserUpdateRequest $request
     * @param User $user
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(DistributorUserUpdateRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $user->fill($request->except('distributor', 'password'));
            if ($request->has('password')) {
                $user->password = Hash::make($request->get('password'));
            }
            $user->save();

            DB::commit();

            alert()->success($user->fullname, __('User updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('distributors.users.index');
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
