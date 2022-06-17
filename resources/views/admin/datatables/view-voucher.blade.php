@php
    $bookingId = $model->booking_reference;
    if (trim($model->in_off_code) !== "") {
        $bookingId = $model->inn_off_code.'-'.$model->booking_reference;
    }
    if ($model->provider->name == 'miki') {
        // TODO: Set MIKI proved booking reference number
    }
@endphp
<a
    href="javascript:void(0)"
    onclick="open_window('{{ route('print.voucher', $model->id) }}')">{{ $bookingId !== '' ? $bookingId : 'N/A' }}
</a>
