@php
    $bookingId = $model->booking_reference;
    if (trim($model->in_off_code) !== "") {
        $bookingId = $model->inn_off_code.'-'.$model->booking_reference;
    }
@endphp
<a
    href="javascript:void(0)"
    onclick="open_window('{{ route('print.voucher', $model->id) }}')">{{ $bookingId !== '' ? $bookingId : 'N/A' }}
</a>
