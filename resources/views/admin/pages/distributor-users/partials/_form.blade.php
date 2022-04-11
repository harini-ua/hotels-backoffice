@php($model = $user ?? null)
<form
    id="distributor-user"
    method="POST"
    action="{{ isset($model) ? route('distributors.users.update', $model) : route('distributors.users.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="distributor" class="col-sm-2 col-form-label">{{ __('Distributor') }} *</label>
        <div class="col-sm-4">
            @if(isset($model))
                <input type="text" id="distributor" name="distributor"
                       class="form-control" disabled value="{{ $distributor->name }}">
            @else
                <select id="distributor" name="distributor"
                        class="form-control select2 select2-single @error('distributor') is-invalid @enderror"
                >
                    <option value="">{{ __('- Choose Distributor -') }}</option>
                    @foreach($distributors as $id => $distributor)
                        <option
                            @if($model && $model->distributor->id === $id) selected @endif
                        value="{{ $id }}"
                        >{{ $distributor }}</option>
                    @endforeach
                </select>
                @error('distributor')
                <small class="form-text text-danger" role="alert">{{ $message }}</small>
                @enderror
            @endif
        </div>
    </div>
    <div class="form-group row">
        <label for="firstname" class="col-sm-2 col-form-label">{{ __('First Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="firstname" name="firstname"
                   value="{{ old('firstname') ?? ($model ? $model->firstname : null ) }}"
                   class="form-control @error('firstname') is-invalid @enderror">
            @error('firstname')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="lastname" class="col-sm-2 col-form-label">{{ __('Last Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="lastname" name="lastname"
                   value="{{ old('lastname') ?? ($model ? $model->lastname : null ) }}"
                   class="form-control @error('lastname') is-invalid @enderror">
            @error('lastname')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">{{ __('Address') }} *</label>
        <div class="col-sm-4">
            <textarea id="address" name="address" rows="3"
                      class="form-control @error('address') is-invalid @enderror"
            >{{ old('address') ?? ($model ? $model->address : null ) }}</textarea>
            @error('address')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }} *</label>
        <div class="col-sm-4">
            <input type="email" id="email" name="email"
                   value="{{ old('email') ?? ($model ? $model->email : null ) }}"
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
                   value="{{ old('username') ?? ($model ? $model->username : null ) }}"
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
    <button class="btn btn-primary">{{ __('Submit') }}</button>
</form>
