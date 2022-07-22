@foreach($hotel->images as $image)
    <div class="d-inline-block mb-3 ml-3">
        <img src="{{ $image->image }}" class="img-fluid rounded" alt="Hotel Image">
    </div>
@endforeach
