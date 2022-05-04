<div class="stars stars-example-fontawesome">
    <div class="br-wrapper br-theme-fontawesome-stars">
        <div class="br-widget">
            @foreach($ratings as $rating)
            <a href="javascript:void(0)" @if($value >= $rating) class="br-selected" @endif></a>
            @endforeach
        </div>
    </div>
</div>
