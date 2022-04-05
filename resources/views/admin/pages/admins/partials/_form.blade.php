<form id="create-admin" method="POST" action="{{ route('admins.store') }}">
    @csrf
    <div class="form-group row">
        <label for="username" class="col-sm-2 col-form-label">{{ __('User Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror">
            @error('username')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }} *</label>
        <div class="col-sm-4">
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="firstname" class="col-sm-2 col-form-label">{{ __('First Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="firstname" name="firstname" class="form-control @error('firstname') is-invalid @enderror">
            @error('firstname')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="lastname" class="col-sm-2 col-form-label">{{ __('Last Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="lastname" name="lastname" class="form-control @error('lastname') is-invalid @enderror">
            @error('lastname')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="address" class="col-sm-2 col-form-label">{{ __('Address') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror">
            @error('address')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }} *</label>
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

@section('script')
    <script src="{{asset('js/scripts/password.js')}}"></script>
@endsection
