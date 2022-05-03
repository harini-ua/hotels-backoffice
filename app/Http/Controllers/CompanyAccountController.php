<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\CompanyAccountUpdateRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CompanyAccountController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Company $company)
    {
        $breadcrumbs = [
            ['title' => __('Edit Company Site Account')],
            ['link' => route('home'), 'name' => __('Home')],
            ['link' => route('companies.index'), 'name' => __('Company Sites')],
            ['name' => $company->company_name]
        ];

        $actions = [
            ['href' => route('companies.create'), 'icon' => 'plus', 'name' => __('Create')]
        ];

        $user = $company->employee;

        return view('admin.pages.companies.account',
            compact('breadcrumbs', 'actions', 'company', 'user')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyAccountUpdateRequest $request
     * @param Company $company
     *
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(CompanyAccountUpdateRequest $request, Company $company)
    {
        try {
            DB::beginTransaction();

            $isNewUser = false;

            $user = $company->employee;

            if (!$user) {
                $isNewUser = true;
                $user = new User();
            }

            $user->fill($request->except('password'));
            $user->email = $company->email;
            $user->password = Hash::make($request->get('password'));
            $user->save();

            if ($isNewUser) {
                $company->employee()->associate($user);
                $user->assignRole(UserRole::EMPLOYEE);
            }

            DB::commit();

            alert()->success(__('Success'), __('Account updated has been successful.'));
        } catch (\PDOException $e) {
            alert()->warning(__('Woops!'), __('Something went wrong, try again.'));
            DB::rollBack();
        }

        return redirect()->route('companies.account.edit', $company);
    }
}
