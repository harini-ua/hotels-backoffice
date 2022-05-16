@php($model = $promoMessage ?? null)
<form
    id="promo-message"
    method="POST"
    action="{{ isset($model) ? route('promo-messages.update', $model) : route('promo-messages.store') }}"
>
    @csrf
    @if(isset($model)) @method('PUT') @endif

    <button class="btn btn-submit">{{ __('Submit') }}</button>
</form>
