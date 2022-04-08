
<form id="create-company" method="POST" action="{{ route('companies.create') }}">
    @csrf
    @method('PUT')
    <button class="btn btn-primary">{{ __('Submit') }}</button>
</form>
