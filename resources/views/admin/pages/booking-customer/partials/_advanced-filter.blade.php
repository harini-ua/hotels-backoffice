<div class="form-group filter-item col-md-2 hide">
    <label for="booking_type">{{ __('Booking Type') }}</label>
    <select
        id="booking_type"
        name="booking_type"
        class="form-control filter-input select-filter"
        data-table="report-booking-customer-list-datatable"
        data-url="{{ route('reports.booking-customer.index') }}"
        @if(!count($bookingTypes)) disabled @endif
    >
        @foreach($bookingTypes as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="order_id">{{ __('Order ID') }}</label>
    <input type="text" id="order_id" name="order_id" class="form-control">
</div>
<div class="form-group filter-item col-md-2">
    <label for="booking_id">{{ __('Booking ID') }}</label>
    <input type="text" id="booking_id" name="booking_id" class="form-control">
</div>
<div class="form-group filter-item col-md-2">
    <label for="status">{{ __('Booking Status') }}</label>
    <select
        id="status"
        name="status"
        class="form-control filter-input select-filter select2-single"
        @if(!count($statuses)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($statuses as $id => $status)
            <option
                value="{{ $id }}"
                {{  App::environment() !== 'local' && \App\Enums\BookingStatus::CONFIRMED == $id ? 'selected' : '' }}
            >{{ $status }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="booking_id">{{ __('Giftcard').'/'.__('Discount') }}</label>
    <input type="text" id="giftcard" name="giftcard" class="form-control">
</div>
<div class="form-group filter-item col-md-2">
    <label for="booking_id">{{ __('Guest Name') }}</label>
    <input type="text" id="guest_name" name="guest_name" class="form-control">
</div>
<div class="form-group filter-item col-md-2">
    <label for="booking_id">{{ __('Guest Email') }}</label>
    <input type="text" id="guest_email" name="guest_email" class="form-control">
</div>
<div class="form-group filter-item col-md-3">
    <label for="date_type">{{ __('Date Type') }}</label>
    <select
        id="date_type"
        name="date_type"
        class="form-control filter-input select-filter select2-single"
        @if(!count($dataTypes)) disabled @endif
    >
        @foreach($dataTypes as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item mr-1 col-md-3">
    <label for="period">{{ __('Date Period') }}</label>
    <div class="input-group">
        <input type="text"
               id="period"
               name="period"
               class="form-control datepicker-filter"
               placeholder="{{ __('Choice First Period') }}"
               aria-describedby="basic-addon7"
               value=""
        >
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon7"><i class="feather icon-calendar"></i></span>
        </div>
    </div>
</div>
<div class="form-group filter-item mr-1">
    <button class="btn btn-submit"
            id="advanced-submit-btn"
            name="advanced_filter"
            data-type="quick"
            data-table="report-booking-customer-list-datatable"
            data-url="{{ route('reports.booking-customer.index') }}"
            style="margin-top: 33px"><i class="feather icon-search"></i> {{ __('Search') }}
    </button>
</div>
