<div class="input-group">
    <input
        type="number"
        class="form-control edit-field"
        id="cities[{{ $model->id }}]['commission']"
        name="commission"
        value="{{ $model->commission }}"
    >
    <div class="input-group-append">
        <span class="input-group-text">%</span>
    </div>
</div>
