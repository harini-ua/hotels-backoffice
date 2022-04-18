<form id="create-admin" method="POST" action="{{ route('newsletters.store') }}">
    @csrf
    <div class="form-group row">
        <label for="type" class="col-sm-2 col-form-label">{{ __('Newsletter Type') }} *</label>
        <div class="col-sm-4">
            <select id="type" name="type" class="form-control @error('type') is-invalid @enderror">
                @foreach($newsletterTypes as $id => $type)
                    <option value="{{ $id }}" @if($id == old('type')) selected @endif>{{ $type }}</option>
                @endforeach
            </select>
            @error('type')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="company_id" class="col-sm-2 col-form-label company_id-label">{{ __('Company Sites') }} *</label>
        <div class="col-sm-4">
            <select id="company_id" name="company_id"
                    class="form-control select2-single @error('company_id') is-invalid @enderror"
            >
                <option value="">{{ __('All') }}</option>
                @foreach($companies as $id => $company)
                    <option value="{{ $id }}" @if($id == old('company_id')) selected @endif>{{ $company }}</option>
                @endforeach
            </select>
            @error('company_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="registered_date_from" class="col-sm-2 col-form-label">{{ __('Registered Date From') }}</label>
        <div class="col-sm-4">
            <div class="input-group">
                <input type="text" id="registered_date_from" name="registered_date_from"
                       class="form-control @error('registered_date_from') is-invalid @enderror"
                       aria-describedby="basic-addon8"
                       value="{{ old('registered_date_from') }}"
                >
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon8"><i class="feather icon-calendar"></i></span>
                </div>
            </div>
            @error('registered_date_from')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="from" class="col-sm-2 col-form-label">{{ __('From') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="from" name="from"
                   class="form-control @error('from') is-invalid @enderror"
                   value="{{ old('from') ?? \Illuminate\Support\Facades\Auth::user()->email }}"
            >
            @error('from')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="subject" class="col-sm-2 col-form-label">{{ __('Subject') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="subject" name="subject"
                   class="form-control @error('subject') is-invalid @enderror"
                   value="{{ old('subject') }}"
            >
            @error('subject')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="message" class="col-sm-2 col-form-label">{{ __('Message') }} *</label>
        <div class="col-sm-10">
            <textarea id="message" name="message"
                      class="form-control tinymce-editor @error('message') is-invalid @enderror"
            >{{ old('message') }}</textarea>
            @error('message')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button id="send-btn" class="btn btn-primary" name="action" value="send">{{ __('Submit') }}</button>
    <button id="download-btn" class="btn btn-primary" name="action" value="export">{{ __('Download') }}</button>
</form>
