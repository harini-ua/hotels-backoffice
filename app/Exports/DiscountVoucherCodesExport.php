<?php

namespace App\Exports;

use App\Models\DiscountVoucher;
use Maatwebsite\Excel\Concerns\FromCollection;

class DiscountVoucherCodesExport implements FromCollection
{
    /** @var DiscountVoucher */
    public $discountVoucher;

    public function __construct(DiscountVoucher $discountVoucher)
    {
        /** @var DiscountVoucher */
        $this->discountVoucher = $discountVoucher;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->discountVoucher->codes()->get('code');
    }
}
