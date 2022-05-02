@php($model = $partnerProduct ?? null)
<form
    id="company"
    method="POST"
    action="{{ isset($model) ? route('partners.products.update', $model) : route('partners.products.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="product_name" class="col-sm-2 col-form-label">{{ __('Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="product_name" name="product_name"
                   value="{{ old('name') ?? ($model ? $model->product_name : null ) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
