<div class="form-group filter-item col-md-2">
    <label for="company">{{ __('By Company Site') }}</label>
    <select
        id="company"
        name="company"
        class="form-control filter-input select-filter select2 select2-single"
        data-table="discount-vouchers-list-datatable"
        data-url="{{ route('discount-vouchers.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($companies as $id => $company)
            <option value="{{ $id }}">{{ $company }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="discount_type">{{ __('By Voucher Type') }}</label>
    <select
        id="voucher_type"
        name="voucher_type"
        class="form-control filter-input select-filter custom-select"
        data-table="discount-vouchers-list-datatable"
        data-url="{{ route('discount-vouchers.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($discountVoucherTypes as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
<div class="form-group filter-item col-md-2">
    <label for="commission_type">{{ __('By Commission Type') }}</label>
    <select
        id="commission_type"
        name="commission_type"
        class="form-control filter-input select-filter custom-select"
        data-table="discount-vouchers-list-datatable"
        data-url="{{ route('discount-vouchers.index') }}"
    >
        <option selected value="">{{ __('All') }}</option>
        @foreach($commissionTypes as $id => $type)
            <option value="{{ $id }}">{{ $type }}</option>
        @endforeach
    </select>
</div>
