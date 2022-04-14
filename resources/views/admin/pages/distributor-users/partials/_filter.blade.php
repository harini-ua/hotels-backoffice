<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Distributor') }}</label>
    <select
        id="distributor"
        name="distributor"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="distributors-users-list-datatable"
        data-url="{{ route('distributors.users.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($distributors as $id => $distributor)
            <option value="{{ $id }}">{{ $distributor }}</option>
        @endforeach
    </select>
</div>
