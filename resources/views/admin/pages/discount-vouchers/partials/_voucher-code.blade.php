@if($model->voucher_type == \App\Enums\DiscountCodeType::AccessForAll)
    {{ $model->codes()->first()->code }}
@endif
@if($model->voucher_type == \App\Enums\DiscountCodeType::Individual)
    <a class="btn btn-primary download-codes" href="{{ route('discount-vouchers.download.codes', $model) }}">
        {{ __('Download') }} <span class="badge badge-light">{{ $model->voucher_codes_count }}</span>
        <span class="sr-only">{{ __('codes') }}</span>
    </a>
@endif
