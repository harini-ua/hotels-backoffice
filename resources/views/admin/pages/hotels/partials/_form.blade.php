<div class="col s12">
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
        <div class="form-group row">
            <label for="rating" class="col-sm-2 col-form-label">{{ __('Star') }}</label>
            <div class="col-sm-4">
                <input type="number" id="rating" name="rating" min="1" max="5"
                       value="{{ old('rating') ?? ($model ? $model->rating : null) }}"
                       class="form-control @error('rating') is-invalid @enderror">
                @error('rating')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="description" class="col-sm-2 col-form-label">{{ __('Description') }}</label>
            <div class="col-sm-6">
                <textarea id="description" name="description" rows="8"
                          class="form-control @error('description') is-invalid @enderror"
                >{{ old('description') ?? ($model ? $model->description : null) }}</textarea>
                @error('description')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="rating" class="col-sm-2 col-form-label">{{ __('Address') }}</label>
            <div class="col-sm-6">
                <textarea id="address" name="address" rows="8"
                       class="form-control @error('address') is-invalid @enderror"
                >{{ old('address') ?? ($model ? $model->address : null) }}</textarea>
                @error('address')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="postal_code" class="col-sm-2 col-form-label">{{ __('Postal Code') }}</label>
            <div class="col-sm-4">
                <input type="text" id="postal_code" name="postal_code"
                       value="{{ old('postal_code') ?? ($model ? $model->postal_code : null) }}"
                       class="form-control @error('postal_code') is-invalid @enderror">
                @error('postal_code')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }}</label>
            <div class="col-sm-4">
                <input type="email" id="email" name="email"
                       value="{{ old('email') ?? ($model ? $model->email : null) }}"
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="phone" class="col-sm-2 col-form-label">{{ __('Phone') }}</label>
            <div class="col-sm-4">
                <input type="text" id="phone" name="phone"
                       value="{{ old('phone') ?? ($model ? $model->phone : null) }}"
                       class="form-control @error('phone') is-invalid @enderror">
                @error('phone')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="fax" class="col-sm-2 col-form-label">{{ __('Fax') }}</label>
            <div class="col-sm-4">
                <input type="text" id="fax" name="fax"
                       value="{{ old('fax') ?? ($model ? $model->fax : null) }}"
                       class="form-control @error('fax') is-invalid @enderror">
                @error('fax')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="website" class="col-sm-2 col-form-label">{{ __('Website') }}</label>
            <div class="col-sm-4">
                <input type="text" id="website" name="website"
                       value="{{ old('website') ?? ($model ? $model->website : null) }}"
                       class="form-control @error('website') is-invalid @enderror">
                @error('website')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="position" class="col-sm-2 col-form-label">{{ __('Location') }}</label>
            <div class="col-sm-4">
                <input type="text" id="position" name="position"
                       value="{{ old('position') ?? ($model && $model->position ? $model->position->getLat().','.$model->position->getLng() : null) }}"
                       class="form-control @error('position') is-invalid @enderror">
                <small class="form-text text-muted">{{ __('Latitude and longitude separated by commas') }}</small>
                @error('position')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="located" class="col-sm-2 col-form-label">{{ __('Located') }}</label>
            <div class="col-sm-4">
                <input type="text" id="located" name="located"
                       value="{{ old('located') ?? ($model ? $model->located : null) }}"
                       class="form-control @error('located') is-invalid @enderror">
                @error('located')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="thumbnail_image" class="col-sm-2 col-form-label">{{ __('Thumbnail Image') }} *</label>
            <div class="col-sm-6">
                <input
                    type="file" id="thumbnail_image" name="thumbnail_image"
                    value="{{ old('thumbnail_image') ?? ($model ? $model->thumbnail_image : null ) }}"
                    class="form-control image-input @error('thumbnail_image') is-invalid @enderror"
                >
                @error('image')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
                <br/>
                    <img
                        @if($model->thumbnail_image)
                        src="{{ filter_var($model->thumbnail_image, FILTER_VALIDATE_URL) ? $model->thumbnail_image : asset('storage/hotels/'.$model->id.'/'.$model->thumbnail_image) }}"
                        @endif
                        class="rounded preview @if(!$model->thumbnail_image) disable @endif"
                    >
            </div>
        </div>
        <div class="form-group row">
            <label for="commission" class="col-sm-2 col-form-label">{{ __('Commission') }}</label>
            <div class="col-sm-4">
                <input type="text" id="commission" name="commission"
                       value="{{ old('commission') ?? ($model ? $model->commission : null) }}"
                       class="form-control @error('commission') is-invalid @enderror">
                @error('commission')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="blacklisted" class="col-sm-2 col-form-label">{{ __('Blacklisted') }}</label>
            <div class="input-group col-sm-4">
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" id="blacklisted" name="blacklisted"
                           value="1"
                           @if($model->blacklisted) checked @endif
                           class="custom-control-input @error('blacklisted') is-invalid @enderror"
                    >
                    <label class="custom-control-label" for="blacklisted"></label>
                </div>
            </div>
        </div>
        <button class="btn btn-submit">{{ __('Submit') }}</button>
    </form>
</div>
