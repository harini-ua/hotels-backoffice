<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Company Site') }}</label>
    <select
        id="company"
        name="company"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="booking-users-list-datatable"
        data-url="{{ route('booking-users.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($companies as $id => $company)
            <option value="{{ $id }}">{{ $company }}</option>
        @endforeach
    </select>
</div>
