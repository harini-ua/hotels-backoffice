@php($model = $hotel ?? null)
<form
    id="hotel-badges"
    method="POST"
    action="{{ route('settings.hotel-badges.update', $model) }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif
    <button class="btn btn-submit" id="submit-btn">{{ __('Submit') }}</button>
</form>
