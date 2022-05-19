@php($model = $country ?? null)
<form
    id="country"
    method="POST"
    action="{{ isset($model) ? route('countries.update', $model->id) : route('countries.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('Country Name') }}</label>
        <div class="col-sm-4">
            <input type="text" id="name" name="name"
                   value="{{ old('name') ?? ($model ? $model->name : null) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="region" class="col-sm-2 col-form-label">{{ __('Region') }}</label>
        <div class="col-sm-4">
            <input type="text" id="region" name="region"
                   value="{{ old('region') ?? ($model ? $model->region : null) }}"
                   class="form-control @error('region') is-invalid @enderror">
            @error('region')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">{{ __('Country Code') }}</label>
        <div class="col-sm-4">
            <input type="text" id="code" name="code"
                   value="{{ old('code') ?? ($model ? $model->code : null) }}"
                   class="form-control @error('code') is-invalid @enderror">
            @error('code')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="currency_id" class="col-sm-2 col-form-label">{{ __('Currency') }} *</label>
        <div class="col-sm-4">
            <select id="currency_id" name="currency_id"
                    class="form-control select2-single @error('currency_id') is-invalid @enderror"
            >
                <option value="">-- {{ __('Select Currency') }} --</option>
                @foreach($currencies as $id => $currency)
                    <option
                        value="{{ $id }}"
                        @if(old('currency_id') == $id) selected @endif
                        @if($model && $model->currency_id == $id) selected @endif
                    >{{ $currency }}</option>
                @endforeach
            </select>
            @error('currency_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="language_id" class="col-sm-2 col-form-label">{{ __('Language') }} *</label>
        <div class="col-sm-4">
            <select id="language_id" name="language_id"
                    class="form-control select2-single @error('language_id') is-invalid @enderror"
            >
                <option value="">-- {{ __('Select Currency') }} --</option>
                @foreach($languages as $id => $language)
                    <option
                        value="{{ $id }}"
                        @if(old('language_id') == $id) selected @endif
                        @if($model && $model->language_id == $id) selected @endif
                    >{{ $language }}</option>
                @endforeach
            </select>
            @error('language_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="active" class="col-sm-2 col-form-label">{{ __('Active') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="active" name="active"
                       value="1"
                       @if($model->active) checked @endif
                       class="custom-control-input @error('active') is-invalid @enderror"
                >
                <label class="custom-control-label" for="active"></label>
            </div>
        </div>
    </div>
{{--    <div class="form-group row">--}}
{{--        <label for="blacklisted" class="col-sm-2 col-form-label">{{ __('Blacklist') }}</label>--}}
{{--        <div class="input-group col-sm-4">--}}
{{--            <div class="custom-control custom-checkbox custom-control-inline">--}}
{{--                <input type="checkbox" id="blacklisted" name="blacklisted"--}}
{{--                       value="1"--}}
{{--                       @if($model->blacklisted) checked @endif--}}
{{--                       class="custom-control-input @error('blacklisted') is-invalid @enderror"--}}
{{--                >--}}
{{--                <label class="custom-control-label" for="blacklisted"></label>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
