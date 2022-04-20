@php($model = $distributor ?? null)
<form
    id="company"
    method="POST"
    action="{{ isset($model) ? route('companies.update', $model) : route('companies.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <div class="form-group row">
        <label for="company_name" class="col-sm-2 col-form-label">{{ __('Company Site Name') }} *</label>
        <div class="col-sm-4">
            <input type="text" id="company_name" name="company_name"
                   value="{{ old('company_name') ?? ($model ? $model->name : null ) }}"
                   class="form-control @error('name') is-invalid @enderror">
            @error('company_name')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="theme_id" class="col-sm-2 col-form-label">{{ __('Theme') }} *</label>
        <div class="col-sm-4">
            <select id="theme_id" name="theme_id" class="form-control @error('theme_id') is-invalid @enderror">
                @foreach($themes as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('theme_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="category" class="col-sm-2 col-form-label">{{ __('Category') }} *</label>
        <div class="col-sm-4">
            <select id="category" name="category" class="form-control @error('status') is-invalid @enderror">
                @foreach($categories as $id => $category)
                    <option value="{{ $id }}">{{ $category }}</option>
                @endforeach
            </select>
            @error('category')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="status" class="col-sm-2 col-form-label">{{ __('Status') }} *</label>
        <div class="col-sm-4">
            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                @foreach($status as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('status')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="admin" class="col-sm-2 col-form-label">{{ __('Administrator') }} *</label>
        <div class="col-sm-4">
            <select id="admin" name="admin" class="form-control @error('status') is-invalid @enderror">
                @foreach($admins as $id => $admin)
                    <option value="{{ $id }}">{{ $admin }}</option>
                @endforeach
            </select>
            @error('admin')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="template_id" class="col-sm-2 col-form-label">{{ __('Template') }} *</label>
        <div class="col-sm-4">
            <select id="template_id" name="template_id"
                    class="form-control @error('template_id') is-invalid @enderror"
            >
                @foreach($templates as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('template_id')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="country" class="col-sm-2 col-form-label">{{ __('Country') }} *</label>
        <div class="col-sm-4">
            <select id="country" name="country"
                    class="form-control select2 select2-single @error('country') is-invalid @enderror"
            >
                <option value="">-- {{ __('Select Country') }} --</option>
                @foreach($countries as $id => $country)
                    <option value="{{ $id }}">{{ $country }}</option>
                @endforeach
            </select>
            @error('country')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-primary">{{ __('Submit') }}</button>
</form>
