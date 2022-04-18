<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Status') }}</label>
    <select
        id="status"
        name="status"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="companies-list-datatable"
        data-url="{{ route('companies.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($status as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Category') }}</label>
    <select
        id="category"
        name="category"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="companies-list-datatable"
        data-url="{{ route('companies.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($categories as $id => $category)
            <option value="{{ $id }}">{{ $category }}</option>
        @endforeach
    </select>
</div>
