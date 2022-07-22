<div class="col s12">
    @php($model = $hotel ?? null)
    <div class="form-group row">
        <label for="name" class="col-sm-3 col-form-label">{{ __('Hotel Name') }}</label>
        <div class="col-sm-6">
            <input type="text" id="name" name="name"
                   value="{{ $model->name }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="star" class="col-sm-3 col-form-label">{{ __('Star') }}</label>
        <div class="col-sm-6">
            <input type="text" id="star" name="star"
                   value="{{ $model->rating }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="description" class="col-sm-3 col-form-label">{{ __('Description') }}</label>
        <div class="col-sm-9">
            <textarea type="text" id="description" name="description" rows="8"
                   class="form-control-plaintext"
                   disabled>{{ $model->description }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-3 col-form-label">{{ __('Address') }}</label>
        <div class="col-sm-9">
            <textarea type="text" id="address" name="address" rows="3"
                      class="form-control-plaintext"
                      disabled>{{ $model->address }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="postal_code" class="col-sm-3 col-form-label">{{ __('Postal Code') }}</label>
        <div class="col-sm-6">
            <input type="text" id="postal_code" name="postal_code"
                   value="{{ $model->postal_code ?? '-' }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-3 col-form-label">{{ __('Email') }}</label>
        <div class="col-sm-6">
            <input type="text" id="email" name="email"
                   value="{{ $model->email ?? '-' }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="phone" class="col-sm-3 col-form-label">{{ __('Phone') }}</label>
        <div class="col-sm-6">
            <input type="text" id="phone" name="phone"
                   value="{{ $model->phone ?? '-' }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="fax" class="col-sm-3 col-form-label">{{ __('Fax') }}</label>
        <div class="col-sm-6">
            <input type="text" id="fax" name="fax"
                   value="{{ $model->fax ?? '-' }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="website" class="col-sm-3 col-form-label">{{ __('Website') }}</label>
        <div class="col-sm-6">
            <input type="text" id="website" name="website"
                   value="{{ $model->website ?? '-' }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="position" class="col-sm-3 col-form-label">{{ __('Location') }}</label>
        <div class="col-sm-6">
            <input type="text" id="position" name="position"
                   value="{{ $model->position ? $model->position->getLat().', '.$model->position->getLng() : null }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="located" class="col-sm-3 col-form-label">{{ __('Located') }}</label>
        <div class="col-sm-6">
            <input type="text" id="located" name="located"
                   value="{{ $model->located ?? '-' }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="commission" class="col-sm-3 col-form-label">{{ __('Commission') }}</label>
        <div class="col-sm-6">
            <input type="text" id="commission" name="commission"
                   value="{{ $model->commission }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
    <div class="form-group row">
        <label for="blacklisted" class="col-sm-3 col-form-label">{{ __('Blacklisted') }}</label>
        <div class="col-sm-6">
            <input type="text" id="blacklisted" name="blacklisted"
                   value="{{ $model->blacklisted ? __('Yes') : __('No') }}"
                   class="form-control-plaintext"
                   disabled>
        </div>
    </div>
</div>
