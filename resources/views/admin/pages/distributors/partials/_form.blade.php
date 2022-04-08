
<form id="create-user" method="POST" action="{{ route('distributors.create') }}">
    @csrf
    @method('PUT')
    <button class="btn btn-primary">{{ __('Submit') }}</button>
</form>
