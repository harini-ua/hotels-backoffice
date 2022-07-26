<div class="custom-control custom-switch">
    <input type="checkbox"
           class="custom-control-input edit-field checkbox-field"
           id="hotel_provider[{{ $model->id }}]['blacklisted']"
           name="blacklisted"
           @if($model->blacklisted) checked @endif
    >
    <label class="custom-control-label" for="hotel_provider[{{ $model->id }}]['blacklisted']"></label>
</div>
