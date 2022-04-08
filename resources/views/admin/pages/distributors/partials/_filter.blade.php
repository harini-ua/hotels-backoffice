<div class="form-row filter-items-wrapper">
    <div class="form-group filter-item col-md-2">
        <label for="company">{{ __('By Company') }}</label>
        <select
            id="company"
            name="company"
            class="form-control filter-input select-filter select2 select2-single"
            data-table="users-list-datatable"
            data-url="{{ route('distributors.index') }}"
        >
            <option selected value="">{{ __('All') }}</option>
            @foreach($companies as $id => $company)
                <option value="{{ $id }}">{{ $company }}</option>
            @endforeach
        </select>
    </div>
    <div class="reset-filters">
        <a href="{{ url()->current() }}" class="reset-btn"><i class="feather icon-x"></i> Reset filters</a>
    </div>
</div>