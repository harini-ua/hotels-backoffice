
<form id="create-booking-user" method="POST" action="{{ route('booking-users.store') }}">
    @csrf
    <div class="form-group row">
        <label for="distributor" class="col-sm-2 col-form-label">{{ __('Distributor') }} *</label>
        <div class="col-sm-4">
            <select id="distributor"
                name="distributor_id"
                class="form-control select2-single linked @error('distributor_id') is-invalid @enderror"
                data-url="/distributors/[id]/companies"
                data-binded-select="company"
            >
                <option selected value="">{{ '- '.__('Choose Distributor').' -' }}</option>
                @foreach($distributors as $id => $distributor)
                    <option
                        value="{{ $id }}"
                        @if(old('distributor_id') == $id) selected @endif
                    >{{ $distributor }}</option>
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
                disabled
            >
                <option selected value="">{{ __('No Available') }}</option>
            </select>
            @error('company_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="firstname" class="col-sm-2 col-form-label">{{ __('First Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="firstname" name="firstname"
                   value="{{ old('firstname') }}"
                   class="form-control @error('firstname') is-invalid @enderror"
            >
            @error('firstname')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="lastname" class="col-sm-2 col-form-label">{{ __('Last Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="lastname" name="lastname"
                   value="{{ old('lastname') }}"
                   class="form-control @error('lastname') is-invalid @enderror"
            >
            @error('lastname')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="email" class="col-sm-2 col-form-label">{{ __('Email') }} *</label>
        <div class="col-sm-4">
            <input type="email" id="email" name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
            >
            @error('email')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="password" class="col-sm-2 col-form-label">{{ __('Password') }} *</label>
        <div class="input-group col-sm-4 mb-3">
            <input type="text" id="password" name="password"
                   value="{{ old('password') }}"
                   class="form-control @error('password') is-invalid @enderror"
            >
            <div class="input-group-append">
                <button class="btn btn-light" type="button" id="generate">{{ __('Generate') }}</button>
            </div>
        </div>
        @error('password')
        <small class="form-text text-danger" role="alert">{{ $message }}</small>
        @enderror
    </div>
    <div class="form-group row">
        <label for="country" class="col-sm-2 col-form-label">{{ __('Country') }} *</label>
        <div class="col-sm-4">
            <select id="country"
                name="country_id"
                class="form-control select2-single @error('country_id') is-invalid @enderror"
            >
                <option selected value="">{{ '- '.__('Choose Country').' -' }}</option>
                @foreach($countries as $id => $country)
                    <option
                        value="{{ $id }}"
                        @if(old('country_id') == $id) selected @endif
                    >{{ $country }}</option>
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
                <option selected value="">{{ '- '.__('Choose Language').' -' }}</option>
                @foreach($languages as $id => $language)
                    <option
                        value="{{ $id }}"
                        @if(old('language_id') == $id) selected @endif
                    >{{ $language }}</option>
                @endforeach
            </select>
            @error('language_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="invoice_allowed" class="col-sm-2 col-form-label">{{ __('Invoice Allowed') }}</label>
        <div class="input-group col-sm-4">
            <div class="custom-control custom-checkbox custom-control-inline">
                <input type="checkbox" id="invoice_allowed" name="invoice_allowed"
                       value="1"
                       @if(old('invoice_allowed')) checked @endif
                       class="custom-control-input @error('invoice_allowed') is-invalid @enderror"
                >
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
        <label for="send_to_email" class="col-sm-2 col-form-label">{{ __('Send to email') }}</label>
        <div class="input-group col-sm-4 mb-3 same-wrapper">
            <input type="email" id="send_to_email" name="send_to_email"
                   value="{{ old('send_to_email') }}"
                   class="form-control insert @error('send_to_email') is-invalid @enderror"
            >
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
