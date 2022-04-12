@php($model = $distributor ?? null)
<form
    id="company"
    method="POST"
    action="{{ isset($model) ? route('companies.update', $model) : route('companies.store') }}"
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
        <label for="categories" class="col-sm-2 col-form-label">{{ __('Category') }} *</label>
        <div class="col-sm-4">
            <select id="categories" name="categories" class="form-control @error('status') is-invalid @enderror">
                @foreach($categories as $id => $category)
                    <option value="{{ $id }}">{{ $category }}</option>
                @endforeach
            </select>
            @error('categories')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label for="admins" class="col-sm-2 col-form-label">{{ __('Administrator') }} *</label>
        <div class="col-sm-4">
            <select id="admins" name="admins"
                    class="form-control select2 select2-single @error('status') is-invalid @enderror">
                @foreach($admins as $id => $admin)
                    <option value="{{ $id }}">{{ $admin }}</option>
                @endforeach
            </select>
            @error('admins')
            <small class="form-text text-danger" role="alert">{{ $message }}</small>
            @enderror
        </div>
    </div>
    <button class="btn btn-primary">{{ __('Submit') }}</button>
</form>
