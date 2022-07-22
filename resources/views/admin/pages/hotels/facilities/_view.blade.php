<div class="badge-list ml-2">
    @foreach($hotel->facilities as $facility)
        <a href="#" class="badge badge-light font-16 mb-1">{{ $facility->name }}</a>
    @endforeach
</div>
