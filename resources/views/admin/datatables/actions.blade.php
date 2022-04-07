@php($routeName = $route ?? str_replace('_', '-', $model->getTable()))
<div class="button-list">
    @includeWhen(in_array('view', $actions, true), 'admin.datatables.view-action', ['model' => $model, 'routeName' => $routeName])
    @includeWhen(in_array('edit', $actions, true), 'admin.datatables.edit-action', ['model' => $model, 'routeName' => $routeName])
    @includeWhen(in_array('copy', $actions, true), 'admin.datatables.copy-action', ['model' => $model, 'routeName' => $routeName])
    @includeWhen(in_array('delete', $actions, true), 'admin.datatables.delete-action', ['model' => $model, 'routeName' => $routeName])

    @includeWhen(in_array('login', $actions, true), 'admin.datatables.login-action', ['model' => $model, 'routeName' => $routeName])
</div>
