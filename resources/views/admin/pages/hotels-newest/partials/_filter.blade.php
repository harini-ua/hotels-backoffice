<div class="form-group filter-item mr-1">
    <label for="period">{{ __('By Period') }}</label>
    <div class="input-group">
        <input type="text"
               id="period"
               name="period"
               class="form-control datepicker-filter"
               placeholder="{{ __('Choice First Period') }}"
               aria-describedby="basic-addon7"
               data-table="hotels-newest-datatable"
               data-url="{{ route('reports.hotels.newest.index') }}"
               value=""
        >
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon7"><i class="feather icon-calendar"></i></span>
        </div>
    </div>
</div>
