
<span
    class='badge badge-{{ ($model->voucher_type == \App\Enums\DiscountCodeType::Individual) ? 'info' : 'success' }}'
>{{ \App\Enums\DiscountCodeType::getDescription($model->voucher_type) }}</span>
