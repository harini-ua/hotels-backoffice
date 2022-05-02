@php($model = $discountVoucher ?? null)
<form
    id="discount-vouchers"
    method="POST"
    action="{{ isset($model) ? route('discount-vouchers.update', $model->id) : route('discount-vouchers.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="company_id" class="col-sm-2 col-form-label">{{ __('Company Site') }} *</label>
        <div class="col-sm-4">
            <select id="company_id" name="company_id"
                    class="form-control select2-single @error('company_id') is-invalid @enderror"
            >
                @foreach($companies as $id => $company)
                    <option value="{{ $id }}" @if(old('company_id') == $id) selected @endif>{{ $company }}</option>
                @endforeach
            </select>
            @error('company_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="name" name="name"
                   class="form-control @error('name') is-invalid @enderror"
                   value="{{ old('name') ?? ($model ? $model->name : null ) }}"
            >
            @error('name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="description" class="col-sm-2 col-form-label">{{ __('Description') }}</label>
        <div class="col-sm-4">
            <textarea id="description" name="description"
                      class="form-control @error('description') is-invalid @enderror"
            >{{ old('description') ?? ($model ? $model->description : null ) }}</textarea>
            @error('description')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="voucher_type" class="col-sm-2 col-form-label">{{ __('Voucher Type') }} *</label>
        <div class="col-sm-4">
            <select id="voucher_type" name="voucher_type"
                    class="form-control @error('voucher_type') is-invalid @enderror"
            >
                @foreach($codeTypes as $id => $type)
                    <option value="{{ $id }}" @if(old('voucher_type') == $id) selected @endif>{{ $type }}</option>
                @endforeach
            </select>
            @error('voucher_type')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-group row {{ old('voucher_type') == '0' ? 'disabled' : '' }}">
        <label for="voucher_codes_count" class="col-sm-2 col-form-label">{{ __('Codes Count') }} *</label>
        <div class="col-sm-4">
            <input type="number" min="1"
                   id="voucher_codes_count" name="voucher_codes_count"
                   class="form-control @error('voucher_codes_count') is-invalid @enderror"
                   value="{{ old('voucher_codes_count') ?? ($model ? $model->voucher_codes_count : null ) }}"
            >
            @error('voucher_codes_count')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row {{ old('voucher_type') == '1' ? 'disabled' : '' }}">
        <label for="voucher_code" class="col-sm-2 col-form-label">{{ __('Voucher Code') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="voucher_code" name="voucher_code"
                   class="form-control @error('voucher_code') is-invalid @enderror"
                   value="{{ old('voucher_code') ?? ($model ? $model->voucher_code : null ) }}"
            >
            @error('voucher_code')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="amount_type" class="col-sm-2 col-form-label">{{ __('Amount Type') }} *</label>
        <div class="col-sm-4">
            <select id="amount_type" name="amount_type"
                    class="form-control @error('amount_type') is-invalid @enderror"
            >
                @foreach($amountTypes as $id => $type)
                    <option value="{{ $id }}" @if(old('amount_type') == $id) selected @endif>{{ $type }}</option>
                @endforeach
            </select>
            @error('amount_type')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="amount" class="col-sm-2 col-form-label">{{ __('Amount') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="amount" name="amount"
                   class="form-control @error('amount') is-invalid @enderror"
                   placeholder="0.00"
                   value="{{ old('amount') ?? ($model ? $model->amount : null ) }}"
            >
            @error('amount')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="min_price" class="col-sm-2 col-form-label">{{ __('Minimum Price') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="min_price" name="min_price"
                   class="form-control @error('min_price') is-invalid @enderror"
                   placeholder="0.00"
                   value="{{ old('min_price') ?? ($model ? $model->min_price : null ) }}"
            >
            @error('min_price')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="commission" class="col-sm-2 col-form-label">{{ __('Commission Deducted From') }} *</label>
        <div class="col-sm-4">
            <select id="commission" name="commission"
                    class="form-control @error('commission') is-invalid @enderror"
            >
                @foreach($commissionTypes as $id => $type)
                    <option value="{{ $id }}" @if(old('commission') == $id) selected @endif>{{ $type }}</option>
                @endforeach
            </select>
            @error('commission')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label for="expiry" class="col-sm-2 col-form-label">{{ __('Expiry') }}</label>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="text" id="expiry" name="expiry"
                       class="datepicker-here form-control @error('expiry') is-invalid @enderror"
                       aria-describedby="basic-addon8"
                       value="{{ old('expiry') ?? ($model ? $model->expiry : null ) }}"
                >
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon8"><i class="feather icon-calendar"></i></span>
                </div>
            </div>
            @error('expiry')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit" id="submit-btn">{{ __('Submit') }}</button>
</form>
