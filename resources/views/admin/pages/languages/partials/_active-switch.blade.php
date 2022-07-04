<div class="custom-control custom-switch">
    <input type="checkbox"
           class="custom-control-input active-switch"
           id="active-switch-language-{{ $model->id }}"
           data-action="{{ route('settings.languages.active', $model) }}"
           @if($model->active) checked @endif
    >
    <label class="custom-control-label" for="active-switch-language-{{ $model->id }}"></label>
</div>
