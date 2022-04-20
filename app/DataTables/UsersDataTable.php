<?php

namespace App\DataTables;

use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
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
        $dataTable =  datatables()->eloquent($query);

        $dataTable->addColumn('company_name', function (User $model) {
            return $model->company_name ?? '-';
        });

        $dataTable->addColumn('username', function (User $model) {
            return $model->username;
        });

        $dataTable->addColumn('fullname', function (User $model) {
            return view('admin.datatables.view-link', ['model' => $model, 'title' => $model->fullname]);
        });

        $dataTable->addColumn('phone', function (User $model) {
            return $model->phone ?? '-';
        });

        $dataTable->addColumn('email', function (User $model) {
            return $model->email;
        });

        $dataTable->addColumn('city', function (User $model) {
            return isset($model->city) ? $model->city->name : '-';
        });

        $dataTable->addColumn('country', function (User $model) {
            return isset($model->country) ? $model->country->name : '-';
        });

        $dataTable->addColumn('created_at', function (User $model) {
            return $model->created_at;
        });

        $dataTable->addColumn('action', function (User $model) {
            return view("admin.datatables.actions", ['actions' => ['login', 'delete'], 'model' => $model]);
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('company')) {
                // TODO: Implement filter by company
            }
        }, true);

        return $dataTable;
    }

    /**
     * Set order columns
     *
     * @param $dataTable
     */
    protected function setOrderColumns($dataTable)
    {
        $dataTable->orderColumn('company_name', static function ($query, $order) {
            $query->orderBy('company_name', $order);
        });

        $dataTable->orderColumn('username', static function ($query, $order) {
            $query->orderBy('username', $order);
        });

        $dataTable->orderColumn('fullname', static function ($query, $order) {
            $query->orderBy('fullname', $order);
        });

        $dataTable->orderColumn('created_at', static function ($query, $order) {
            $query->orderBy('created_at', $order);
        });
    }

    /**
     * Set filter columns
     *
     * @param $dataTable
     */
    protected function setFilterColumns($dataTable)
    {
        $dataTable->filterColumn('company_name', static function ($query, $keyword) {
            $query->where('company_name', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('username', static function ($query, $keyword) {
            $query->where('username', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('fullname', static function ($query, $keyword) {
            $query->where('firstname', 'like', "%$keyword%")
                ->orWhere('lastname', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('email', static function ($query, $keyword) {
            $query->where('email', 'like', "%$keyword%");
        });
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
            ->whereHas("roles", function ($q) {
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
            ->language([
                'search' => '',
                'searchPlaceholder' => __('Search')
            ])
            ->buttons(
                Button::make('postExcel'),
                Button::make('print')
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
            Column::make('company_name')->title(__('Company Site')),
            Column::make('username')->title(__('User Name')),
            Column::make('fullname')->title(__('Full Name')),
            Column::make('phone')->title(__('Telephone'))
                ->orderable(false),
            Column::make('email')->orderable(false)
                ->orderable(false),
            Column::make('city')
                ->orderable(false),
            Column::make('country')
                ->orderable(false),
            Column::make('created_at')->title(__('Created Date')),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(150)
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
