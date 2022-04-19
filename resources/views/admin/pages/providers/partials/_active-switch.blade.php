<div class="custom-control custom-switch">
    <input type="checkbox"
           class="custom-control-input active-switch"
           id="active-switch-provider-{{ $model->id }}"
           data-action="{{ route('providers.active', $model) }}"
           @if($model->active) checked @endif
    >
    <label class="custom-control-label" for="active-switch-provider-{{ $model->id }}"></label>
</div>
