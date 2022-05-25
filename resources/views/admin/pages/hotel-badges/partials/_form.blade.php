@php($model = $hotel ?? null)
<form
    id="hotel-badges"
    method="POST"
    action="{{ route('settings.hotel-badges.update', $model) }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="priority_rating" class="col-sm-2 col-form-label">{{ __('Priority Rating') }}</label>
        <div class="col-sm-2">
            <select id="priority_rating" name="priority_rating"
                    class="form-control custom-select @error('priority_rating') is-invalid @enderror"
            >
                <option value="0">0</option>
                @foreach($sortNumbers as $number)
                    <option value="{{ $number }}"
                            @if(old('priority_rating') == $number) selected @endif
                            @if($model && $model->priority_rating == $number) selected @endif
                    >{{ $number }}</option>
                @endforeach
            </select>
            @error('priority_rating')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="recommended" class="col-sm-2 col-form-label">{{ __('Recommended Rating') }}</label>
        <div class="col-sm-2">
            <select id="recommended" name="recommended"
                    class="form-control custom-select @error('recommended') is-invalid @enderror"
            >
                <option value="0">0</option>
                @foreach($sortNumbers as $number)
                    <option value="{{ $number }}"
                            @if(old('recommended') == $number) selected @endif
                            @if($model && $model->recommended == $number) selected @endif
                    >{{ $number }}</option>
                @endforeach
            </select>
            @error('recommended')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="other_rating" class="col-sm-2 col-form-label">{{ __('Other Rating') }}</label>
        <div class="col-sm-2">
            <select id="other_rating" name="other_rating"
                    class="form-control custom-select @error('other_rating') is-invalid @enderror"
            >
                <option value="0">0</option>
                @foreach($sortNumbers as $number)
                    <option value="{{ $number }}"
                            @if(old('other_rating') == $number) selected @endif
                            @if($model && $model->other_rating == $number) selected @endif
                    >{{ $number }}</option>
                @endforeach
            </select>
            @error('other_rating')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="commission" class="col-sm-2 col-form-label">{{ __('Hotel Commission') }}</label>
        <div class="col-sm-2">
            <input type="number" id="commission" name="commission" min="1" max="100"
                   class="form-control @error('commission') is-invalid @enderror"
                   value="{{ old('commission') ?? ($model ? $model->commission : 0) }}"
            >
            @error('commission')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="special_offer" class="col-sm-2 col-form-label">{{ __('Special Hotel Offer') }}</label>
        <div class="col-sm-2">
            <input type="number" id="special_offer" name="special_offer" min="0.01" step="0.01"
                   placeholder="0,00"
                   class="form-control @error('special_offer') is-invalid @enderror"
                   value="{{ old('special_offer') ?? ($model ? $model->special_offer : null) }}"
            >
            @error('special_offer')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="blacklisted" class="col-sm-2 col-form-label">{{ __('Blacklist') }}</label>
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
    <button class="btn btn-submit" id="submit-btn">{{ __('Submit') }}</button>
</form>
