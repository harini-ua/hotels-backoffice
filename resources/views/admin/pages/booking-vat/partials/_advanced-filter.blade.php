<div class="form-group filter-item mr-1 col-md-2">
    <label for="order_id">{{ __('Order ID') }}</label>
    <input type="text"
           id="order_id"
           name="order_id"
           data-table="report-booking-vat-list-datatable"
           data-url="{{ route('reports.booking-vat.index') }}"
           class="form-control"
    >
</div>
<div class="form-group filter-item mr-1 col-md-2">
    <label for="booking_id">{{ __('Booking ID') }}</label>
    <input type="text"
           id="booking_id"
           name="booking_id"
           data-table="report-booking-vat-list-datatable"
           data-url="{{ route('reports.booking-vat.index') }}"
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
               data-table="report-booking-vat-list-datatable"
               data-url="{{ route('reports.booking-vat.index') }}"
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
            data-table="report-booking-vat-list-datatable"
            data-url="{{ route('reports.booking-vat.index') }}"
            style="margin-top: 33px"><i class="feather icon-search"></i> {{ __('Search') }}
    </button>
</div>
