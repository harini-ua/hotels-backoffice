<div class="form-group filter-item col-md-2">
    <label for="booking_type">{{ __('Search Type') }}</label>
    <div class="input-group">
        <input class="form-control-plaintext font-weight-bold" value="{{ __('Quick Search') }}:">
    </div>
</div>
<div class="form-group filter-item col-md-2">
    <label for="booking_type">{{ __('Booking Type') }}</label>
    <select
        id="booking_type"
        name="booking_type"
        class="form-control filter-input select-filter"
        data-table="report-booking-commission-list-datatable"
        data-url="{{ route('reports.booking-commission.index') }}"
        @if(!count($bookingTypes)) disabled @endif
    >
        @foreach($bookingTypes as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('Company Site') }}</label>
    <select
        id="company"
        name="company"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="report-booking-customer-list-datatable"
        data-url="{{ route('reports.booking-customer.index') }}"
        @if(!count($companies)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($companies as $id => $company)
            <option value="{{ $id }}">{{ $company }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item mr-1 col-md-3">
    <label for="check_in">{{ __('Check In') }}</label>
    <div class="input-group">
        <input type="text"
               id="check_in"
               name="check_in"
               class="form-control datepicker-filter"
               placeholder="{{ __('Choice Period Date') }}"
               aria-describedby="basic-addon7"
               data-table="report-booking-customer-list-datatable"
               data-url="{{ route('reports.booking-customer.index') }}"
               value=""
        >
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon7"><i class="feather icon-calendar"></i></span>
        </div>
    </div>
</div>
<div class="form-group filter-item mr-1">
    <button class="btn btn-submit"
            id="quick-submit-btn"
            data-type="quick"
            data-table="report-booking-customer-list-datatable"
            data-url="{{ route('reports.booking-customer.index') }}"
            style="margin-top: 33px"><i class="feather icon-search"></i> {{ __('Search') }}
    </button>
</div>
<div class="col-md-12">
    <hr/>
</div>
<div class="form-group filter-item col-md-2">
    <label for="booking_type">{{ __('Search Type') }}</label>
    <div class="input-group">
        <input class="form-control-plaintext font-weight-bold" value="{{ __('Advanced Search') }}:">
    </div>
</div>
<div class="form-group filter-item mr-1 col-md-2">
    <label for="order_id">{{ __('Order ID') }}</label>
    <input type="text"
           id="order_id"
           name="order_id"
           data-table="report-booking-customer-list-datatable"
           data-url="{{ route('reports.booking-customer.index') }}"
           class="form-control"
    >
</div>
<div class="form-group filter-item mr-1 col-md-2">
    <label for="booking_id">{{ __('Booking ID') }}</label>
    <input type="text"
           id="booking_id"
           name="booking_id"
           data-table="report-booking-customer-list-datatable"
           data-url="{{ route('reports.booking-customer.index') }}"
           class="form-control"
    >
</div>
<div class="form-group filter-item mr-1 col-md-3">
    <label for="voucher_date">{{ __('Voucher Date') }}</label>
    <div class="input-group">
        <input type="text"
               id="voucher_date"
               name="voucher_date"
               class="form-control datepicker-filter"
               placeholder="{{ __('Choice Period Date') }}"
               aria-describedby="basic-addon7"
               data-table="report-booking-customer-list-datatable"
               data-url="{{ route('reports.booking-customer.index') }}"
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
            data-type="quick"
            data-table="report-booking-customer-list-datatable"
            data-url="{{ route('reports.booking-customer.index') }}"
            style="margin-top: 33px"><i class="feather icon-search"></i> {{ __('Search') }}
    </button>
</div>
