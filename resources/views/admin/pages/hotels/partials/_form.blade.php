@php($model = $hotel ?? null)
<form id="city" method="POST" action="{{ route('hotels.update', $model->id) }}">
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('Hotel Name') }}</label>
        <div class="col-sm-4">
            <input type="text" id="name" name="name"
                   value="{{ old('name') ?? ($model ? $model->name : null) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
