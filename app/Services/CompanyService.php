<?php

namespace App\Services;

use App\Enums\CompanyCategory;
use App\Enums\CompanyStatus;
use App\Models\Company;
use App\Models\CompanyTemplate;
use App\Models\CompanyTheme;
use App\Models\Country;
use App\Models\User;
use Carbon\Carbon;

class CompanyService
{
    /** @var Company */
    protected $company;

    /**
     * Set company resource
     *
     * @param Company $company
     * @return CompanyService
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get payload data
     *
     * @return array|void
     */
    public function payload($action = 'create')
    {
        if (method_exists(self::class, 'get'.ucfirst($action).'Payload')) {
            /** @uses getCreatePayload() */
            return $this->{'get'.ucfirst($action).'Payload'}();
        }
    }

    /**
     * Replicate a company
     *
     * @param $newName
     * @return Company
     */
    public function duplicate($newName = null)
    {
        $newCompany = $this->company->replicate();
        $newCompany->company_name = $newName ?? $this->company->company_name.' (Copy)';
        $newCompany->holder_name = $newCompany->company_name; // TODO: Need to be clarified
        $newCompany->created_at = Carbon::now();
        $newCompany->save();

        // TODO: Implement duplicate all relationship

        return $newCompany;
    }

    /**
     * Get payload data for create company
     *
     * @return array
     */
    protected function getCreatePayload()
    {
        $themes = CompanyTheme::all()
            ->sortBy('theme_name')
            ->pluck('theme_name', 'id');

        $templates = CompanyTemplate::all()
            ->sortBy('name')
            ->pluck('name', 'id');

        $status = CompanyStatus::asSelectArray();

        $categories = CompanyCategory::asSelectArray();

        $admins = User::where('status', 1)
            ->whereHas("roles", function ($q) {
                $q->where("name", "admin");
            })->get()
            ->sortBy('fullname')
            ->pluck('fullname', 'id');

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return [
            $themes,
            $templates,
            $status,
            $categories,
            $admins,
            $countries
        ];
    }

    /**
     * Get payload data for edit company
     *
     * @return array
     */
    protected function getEditPayload()
    {
        $themes = CompanyTheme::all()
            ->sortBy('theme_name')
            ->pluck('theme_name', 'id');

        $templates = CompanyTemplate::all()
            ->sortBy('name')
            ->pluck('name', 'id');

        $status = CompanyStatus::asSelectArray();

        $categories = CompanyCategory::asSelectArray();

        $admins = User::where('status', 1)
            ->whereHas("roles", function ($q) {
                $q->where("name", "admin");
            })->get()
            ->sortBy('fullname')
            ->pluck('fullname', 'id');

        $countries = Country::all()
            ->where('active', 1)
            ->sortBy('name')
            ->pluck('name', 'id');

        return [
            $themes,
            $templates,
            $status,
            $categories,
            $admins,
            $countries
        ];
    }
}
