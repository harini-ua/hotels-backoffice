<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Company Site') }}</label>
    <select
        id="company"
        name="company"
        class="form-control filter-input select-filter select2-single"
        data-table="searching-period-list-datatable"
        data-url="{{ route('statistics.searching-period.index') }}"
        @if(!count($companies)) disabled @endif
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($companies as $id => $company)
            <option value="{{ $id }}">{{ $company }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-3">
    <label for="period-first">{{ __('Select First Period') }}</label>
    <div class="input-group">
        <input type="text"
               id="period-first"
               name="period-first"
               class="datepicker-here form-control filter-input"
               placeholder="dd/mm/yyyy - dd/mm/yyyy"
               aria-describedby="basic-addon7"
        >
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon7"><i class="feather icon-calendar"></i></span>
        </div>
    </div>
</div>
<div class="form-group filter-item col-md-3">
    <label for="period-second">{{ __('Select Second Period') }}</label>
    <div class="input-group">
        <input type="text"
               id="period-second"
               name="period-second"
               class="datepicker-here form-control filter-input"
               placeholder="dd/mm/yyyy - dd/mm/yyyy"
               aria-describedby="basic-addon7"
        >
        <div class="input-group-append">
            <span class="input-group-text" id="basic-addon7"><i class="feather icon-calendar"></i></span>
        </div>
    </div>
</div>
