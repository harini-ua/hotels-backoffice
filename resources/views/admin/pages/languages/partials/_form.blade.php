@php($model = $language ?? null)
<form
    id="language"
    method="POST"
    action="{{ isset($model) ? route('settings.languages.update', $model) : route('settings.languages.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('Language Name') }} *</label>
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
        <label for="translation" class="col-sm-2 col-form-label">{{ __('Translation') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="translation" name="translation"
                   value="{{ old('translation') ?? ($model ? $model->translation : null) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('translation')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="code" class="col-sm-2 col-form-label">{{ __('Language Code') }} *</label>
        <div class="col-sm-4">
            <select id="code" name="code"
                    class="form-control select2 select2-single @error('code') is-invalid @enderror"
            >
                <option value="">-- {{ __('Select Language Code') }} --</option>
                @foreach($languages as $code => $language)
                    <option
                        value="{{ $code }}"
                        @if(old('code') == $code) selected @endif
                        @if($model && $model->code == $code) selected @endif
                    >{{ $language }}</option>
                @endforeach
            </select>{{ $model->code }}
            @error('code')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="payex_code" class="col-sm-2 col-form-label">{{ __('Payex Language Code') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="payex_code" name="payex_code"
                   value="{{ old('payex_code') ?? ($model ? $model->payex_code : null) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('payex_code')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
