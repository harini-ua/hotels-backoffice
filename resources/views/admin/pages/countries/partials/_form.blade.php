@php($model = $country ?? null)
<form
    id="country"
    method="POST"
    action="{{ isset($model) ? route('countries.update', $model->id) : route('countries.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif

    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
