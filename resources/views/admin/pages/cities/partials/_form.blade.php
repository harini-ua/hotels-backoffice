@php($model = $city ?? null)
<form
    id="city"
    method="POST"
    action="{{ isset($model) ? route('cities.update', $model->id) : route('cities.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif

    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
