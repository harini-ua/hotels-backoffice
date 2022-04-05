<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('company_name', function(User $user) {
                return $user->company_name ?? '-';
            })
            ->addColumn('username', function(User $user) {
                return $user->username;
            })
            ->addColumn('fullname', function(User $user) {
                return $user->fullname;
            })
            ->addColumn('phone', function(User $user) {
                return $user->phone ?? '-';
            })
            ->addColumn('email', function(User $user) {
                return $user->email;
            })
            ->addColumn('city', function(User $user) {
                return isset($user->city) ? $user->city->name : '-';
            })
            ->addColumn('country', function(User $user) {
                return isset($user->country) ? $user->country->name : '-';
            })
            ->addColumn('created_at', function(User $user) {
                return $user->created_at;
            })
            ->addColumn('action', function (User $user) {
                return view("admin.datatables.actions", ['actions' => ['login'], 'model' => $user]);
            })
        ;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery()
            ->with(['city', 'country'])
            ->select('users.*')
            ->whereHas("roles", function($q) {
                $q->where("name", "employee");
            })
        ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('users-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('postExcel'),
                Button::make('print'),
                Button::make('reload')
            )
        ;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title(__('ID')),
            Column::make('company_name')->title(__('Company')),
            Column::make('username')->title(__('User Name')),
            Column::make('fullname')->title(__('Full Name')),
            Column::make('phone')->title(__('Telephone')),
            Column::make('email')->orderable(false),
            Column::make('city'),
            Column::make('country'),
            Column::make('created_at')->title(__('Created Date')),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
