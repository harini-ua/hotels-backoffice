@php($routeName = $route ?? str_replace('_', '-', $model->getTable()))
<div class="button-list">
    @includeWhen(in_array('duplicate', $actions, true), 'admin.pages.companies.partials._duplicate-action', ['model' => $model, 'routeName' => $routeName])

    @includeWhen(in_array('save', $actions, true), 'admin.datatables.save-action', ['model' => $model, 'routeName' => $routeName])

    @includeWhen(in_array('view', $actions, true), 'admin.datatables.view-action', ['model' => $model, 'routeName' => $routeName])
    @includeWhen(in_array('edit', $actions, true), 'admin.datatables.edit-action', ['model' => $model, 'routeName' => $routeName])
    @includeWhen(in_array('copy', $actions, true), 'admin.datatables.copy-action', ['model' => $model, 'routeName' => $routeName])
    @includeWhen(in_array('delete', $actions, true), 'admin.datatables.delete-action', ['model' => $model, 'routeName' => $routeName])

    @includeWhen(in_array('payment', $actions, true), 'admin.datatables.payment-action', ['model' => $model, 'routeName' => $routeName])

    @includeWhen(in_array('login', $actions, true), 'admin.datatables.login-action', ['model' => $model, 'routeName' => $routeName])
    @includeWhen(in_array('create_distributor_user', $actions, true), 'admin.datatables.create-distributor-user', ['model' => $model, 'routeName' => $routeName])
</div>
