
<form id="create-user" method="POST" action="{{ route('users.create') }}">
    @csrf
    @method('PUT')
    <div class="form-group row">
        <label for="distributor" class="col-sm-2 col-form-label">{{ __('Distributor') }} *</label>
        <div class="col-sm-4">
            <select id="distributor"
                name="distributor_id"
                class="form-control select2-single linked @error('distributor_id') is-invalid @enderror"
            >
                @foreach($distributors as $id => $distributor)
                    <option value="{{ $id }}">{{ $distributor }}</option>
                @endforeach
            </select>
            @error('distributor_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="company" class="col-sm-2 col-form-label">{{ __('Company Site') }} *</label>
        <div class="col-sm-4">
            <select id="company"
                name="company_id"
                class="form-control select2-single @error('company_id') is-invalid @enderror"
                data-linked="distributor"
            >
                @foreach($companies as $id => $company)
                    <option value="{{ $id }}">{{ $company }}</option>
                @endforeach
            </select>
            @error('company_id')
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
        <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }} *</label>
        <div class="col-sm-4">
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror">
            @error('email')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }} *</label>
        <div class="input-group col-sm-4 mb-3">
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" >
            <div class="input-group-append">
                <button class="btn btn-light" type="button" id="generate">{{ __('Generate') }}</button>
            </div>
            @error('password')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="country" class="col-sm-2 col-form-label">{{ __('Country') }} *</label>
        <div class="col-sm-4">
            <select id="country"
                name="country_id"
                class="form-control select2-single @error('country_id') is-invalid @enderror"
            >
                <option selected value=""></option>
                @foreach($countries as $id => $country)
                    <option value="{{ $id }}">{{ $country }}</option>
                @endforeach
            </select>
            @error('country_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="language" class="col-sm-2 col-form-label">{{ __('Language') }} *</label>
        <div class="col-sm-4">
            <select id="language"
                name="language_id"
                class="form-control select2-single @error('language_id') is-invalid @enderror"
            >
                <option selected value=""></option>
                @foreach($languages as $id => $language)
                    <option value="{{ $id }}">{{ $language }}</option>
                @endforeach
            </select>
            @error('language_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="invoice_allowed" class="col-sm-2 col-form-label">{{ __('Invoice Allowed') }} *</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="invoice_allowed" name="invoice_allowed" class="custom-control-input @error('invoice_allowed') is-invalid @enderror">
                <label class="custom-control-label" for="invoice_allowed"></label>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <h6 class="card-subtitle col-sm-6 ">
            {{ __('Please note that by selecting invoice allowed the user can book without making payment.
Be extremely cautios when creating these users and sending the details to the correct person.') }}
        </h6>
    </div>
    <div class="form-group row">
        <label for="send_to_email" class="col-sm-2 col-form-label">{{ __('Send to email') }} *</label>
        <div class="input-group col-sm-4 mb-3 same-wrapper">
            <input type="email" id="send_to_email" name="send_to_email" class="form-control insert @error('send_to_email') is-invalid @enderror" >
            <div class="input-group-append">
                <button class="btn btn-light same" data-same="email" type="button">{{ __('Same') }}</button>
            </div>
            @error('send_to_email')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-primary">{{ __('Submit') }}</button>
</form>
