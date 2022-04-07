<div class="form-row filter-items-wrapper">
    <div class="form-group filter-item col-md-2">
        <label for="company">{{ __('Company') }}</label>
        <select
            id="company"
            name="company"
            class="form-control filter-input select-filters select2 select2-single"
            data-table="users-list-datatable"
            data-url="{{ route('users.index') }}"
        >
            <option selected value="">{{ __('All') }}</option>
            <option value="1">{{ __('360') }}</option>
            @foreach($companies as $id => $company)
                <option value="{{ $id }}">{{ $company }}</option>
            @endforeach
        </select>
    </div>
</div>
