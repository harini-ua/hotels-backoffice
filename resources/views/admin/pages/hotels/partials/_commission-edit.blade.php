<div class="input-group">
    <input
        type="number"
        class="form-control edit-field"
        id="hotels[{{ $model->id }}]['commission']"
        name="commission"
        value="{{ $model->commision }}"
    >
    <div class="input-group-append">
        <span class="input-group-text">%</span>
    </div>
</div>
