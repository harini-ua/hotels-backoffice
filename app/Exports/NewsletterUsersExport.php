<?php

namespace App\Exports;

use App\Enums\NewsletterUserType;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class NewsletterUsersExport implements FromCollection
{
    /** @var array */
    public array $detail;

    public function __construct($detail)
    {
        $this->detail = $detail;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = (new User)->newQuery();

        switch ($this->detail['type']) {
            case NewsletterUserType::All:
                $query->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['employee', 'booking']);
                });
                break;
            case NewsletterUserType::CompanySiteClient:
                $query->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['employee']);
                });
                break;
            case NewsletterUserType::BookingUsers:
                $query->whereHas('roles', function ($q) {
                    $q->whereIn('name', ['booking']);
                });
                break;
        }

        if ($this->detail['company_id']) {
            $query->whereHas('companies', function ($q) {
                $q->where('id', $this->detail['company_id']);
            });
        }

        if ($this->detail['registered_date_from']) {
            $query->whereDate('created_at', '>=', $this->detail['registered_date_from']);
        }

        return $query->get(['email', 'username']);
    }
}
