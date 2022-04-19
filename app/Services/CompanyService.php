<?php

namespace App\Services;

use App\Models\Company;
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
}
