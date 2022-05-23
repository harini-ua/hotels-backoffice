@php($model = $country ?? null)
<form
    id="country-update-locations"
    method="POST"
    action="{{ route('countries.update.locations', $model->id) }}"
>
    @csrf
    <div class="form-group row">
        <label for="google_api_key" class="col-sm-4 col-form-label">{{ __('Google API Key') }} *</label>
        <div class="col-sm-8">
            <input type="text" id="google_api_key" name="google_api_key"
                   value="{{ old('google_api_key') }}"
                   class="form-control @error('google_api_key') is-invalid @enderror">
            @error('google_api_key')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit run">{{ __('Run') }}</button>
</form>

<div class="update-results" style="display: none">
    <br/>
</div>
