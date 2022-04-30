<?php

namespace App\Exports;

use App\Models\AccessCode;
use App\Models\Company;
use Maatwebsite\Excel\Concerns\FromCollection;

class AccessCodesExport implements FromCollection
{
    /** @var Company */
    public $company;
    /** @var AccessCode|null */
    public $accessCode;

    public function __construct(Company $company, AccessCode $accessCode)
    {
        /** @var Company */
        $this->company = $company;
        $this->accessCode = $accessCode;

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = $this->company->accessCodes();

        if ($this->accessCode) {
            $query->where('created_at', $this->accessCode->created_at);
        }

        return $query->get('code');
    }
}
