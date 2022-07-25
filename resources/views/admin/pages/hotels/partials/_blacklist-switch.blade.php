<div class="custom-control custom-switch">
    <input type="checkbox"
           class="custom-control-input edit-field checkbox-field"
           id="hotels[{{ $model->id }}]['blacklisted']"
           name="hotels[{{ $model->id }}]['blacklisted']"
           @if($model->blacklisted) checked @endif
    >
    <label class="custom-control-label" for="blacklist-switch-provider-{{ $model->id }}"></label>
</div>
