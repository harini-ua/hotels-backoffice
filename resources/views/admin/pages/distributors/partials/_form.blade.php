@php($model = $distributor ?? null)
<form
    id="distributor"
    method="POST"
    action="{{ isset($model) ? route('distributors.update', $model) : route('distributors.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="name" class="col-sm-2 col-form-label">{{ __('Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="name" name="name"
                value="{{ old('name') ?? ($model ? $model->name : null ) }}"
                class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="phone" class="col-sm-2 col-form-label">{{ __('Phone') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="phone" name="phone"
                   value="{{ old('phone') ?? ($model ? $master->phone : null ) }}"
                   class="form-control @error('phone') is-invalid @enderror">
            @error('phone')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }} *</label>
        <div class="col-sm-4">
            <input type="email" id="email" name="email"
                   value="{{ old('email') ?? ($model ? $master->email : null ) }}"
                   class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="username" class="col-sm-2 col-form-label">{{ __('User Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="username" name="username"
                   value="{{ old('username') ?? ($model ? $master->username : null ) }}"
                   class="form-control @error('username') is-invalid @enderror">
            @error('username')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }}</label>
        <div class="input-group col-sm-4 mb-3">
            <input type="text" id="password" name="password" class="form-control @error('password') is-invalid @enderror" >
            <div class="input-group-append">
                <button class="btn btn-light" type="button" id="generate">{{ __('Generate') }}</button>
            </div>
            @error('password')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">{{ __('Address') }} *</label>
        <div class="col-sm-4">
            <textarea id="address" name="address" rows="3"
                      class="form-control @error('address') is-invalid @enderror"
            >{{ old('address') ?? ($model ? $master->address : null ) }}</textarea>
            @error('address')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="country_ids[]" class="col-sm-2 col-form-label">{{ __('Country') }} *</label>
        <div class="col-sm-4">
            <select id="country_ids[]" name="country_ids[]"
                class="form-control select2-multi-select @error('country_ids') is-invalid @enderror"
                @if(!$countries->count()) disabled @endif
                multiple
            >
                @if(!$countries->count())
                    <option>{{ '- '.__('No Available Country').' -' }}</option>
                @endif
                @foreach($countries as $id => $country)
                    <option
                        value="{{ $id }}"
                        @if($model && in_array($id, $model->countries->pluck('id')->toArray(), true)) selected @endif
                    >{{ $country }}</option>
                @endforeach
            </select>
            @error('country_ids')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="language_ids[]" class="col-sm-2 col-form-label">{{ __('Language') }} *</label>
        <div class="col-sm-4">
            <select id="language_ids[]" name="language_ids[]"
                class="form-control select2-multi-select @error('language_ids') is-invalid @enderror"
                @if(!$languages->count()) disabled @endif
                multiple
            >
                @if(!$languages->count())
                    <option>{{ '- '.__('No Available Language').' -' }}</option>
                @endif
                @foreach($languages as $id => $language)
                    <option
                        value="{{ $id }}"
                        @if($model && in_array($id, $model->languages->pluck('id')->toArray(), true)) selected @endif
                    >{{ $language }}</option>
                @endforeach
            </select>
            @error('language_ids')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="company_ids[]" class="col-sm-2 col-form-label">{{ __('Company Site') }} *</label>
        <div class="col-sm-4">
            <select id="company_ids[]" name="company_ids[]"
                class="form-control select2-multi-select @error('company_ids') is-invalid @enderror"
                @if(!$companies->count()) disabled @endif
                multiple
            >
                @if(!$companies->count())
                    <option>{{ '- '.__('No Available Company').' -' }}</option>
                @endif
                @foreach($companies as $id => $company)
                    <option
                        value="{{ $id }}"
                        @if($model && in_array($id, $model->companies->pluck('id')->toArray(), true)) selected @endif
                    >{{ $company }}</option>
                @endforeach
            </select>
            @error('company_ids')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
