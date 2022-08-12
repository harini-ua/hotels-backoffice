@php
    if ($model->provider->name === 'grn') {
        $bookingId = $model->booking_reference;
    } elseif ($model->inn_off_code) {
        $bookingId = $model->inn_off_code .'-'. $model->booking_reference;
    } elseif ($model->provider->name === 'miki') {
        $bookingId = $model->booking_reference .' - '. $model->additional_booking_reference;
    } else {
        $bookingId = $model->booking_reference;
    }
@endphp
<a
    href="javascript:void(0)"
    onclick="open_window('{{ route('print.voucher', $model->id) }}')"
>{{ (in_array($bookingId, ['', ' '])) ? 'N/A' : $bookingId }}</a>
