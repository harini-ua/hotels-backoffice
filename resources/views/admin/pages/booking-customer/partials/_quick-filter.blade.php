<div class="form-group filter-item col-md-2 hide">
    <label for="booking_type">{{ __('Booking Type') }}</label>
    <select
        id="booking_type"
        name="booking_type"
        class="form-control filter-input select-filter"
        @if(!count($bookingTypes)) disabled @endif
    >
        @foreach($bookingTypes as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
    </select>
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
    <label for="company">{{ __('Company Site') }}</label>
    <select
        id="company"
        name="company"
        class="form-control filter-input select-filter select2 select2-single"
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
            name="quick_filter"
            data-type="quick"
            data-table="report-booking-customer-list-datatable"
            data-url="{{ route('reports.booking-customer.index') }}"
            style="margin-top: 33px"><i class="feather icon-search"></i> {{ __('Search') }}
    </button>
</div>
