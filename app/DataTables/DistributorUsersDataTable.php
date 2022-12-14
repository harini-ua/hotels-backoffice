<?php

namespace App\DataTables;

use App\Enums\UserRole;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DistributorUsersDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('fullname', function (User $model) {
            return $model->fullname;
        });

        $dataTable->addColumn('username', function (User $model) {
            return $model->username;
        });

        $dataTable->addColumn('email', function (User $model) {
            return $model->email;
        });

        $dataTable->addColumn('distributor', function (User $model) {
            return $model->distributors->first() ? $model->distributors->first()->name : '-';
        });

        $dataTable->addColumn('action', function (User $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'distributors.users'
            ]);
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        if ((\Auth::user())->hasRole(UserRole::ADMIN)) {
            $dataTable->filter(function ($query) {
                if ($this->request->has(UserRole::DISTRIBUTOR)) {
                    $query->whereHas('distributors', function ($q) {
                        $q->where('distributors.id', $this->request->get('distributor'));
                    });
                }
            }, true);
        }

        return $dataTable;
    }

    /**
     * Set order columns
     *
     * @param $dataTable
     */
    protected function setOrderColumns($dataTable)
    {
//        $dataTable->orderColumn('fullname', static function ($query, $order) {
//            $query->orderBy('fullname', $order);
//        });

        $dataTable->orderColumn('name', static function ($query, $order) {
            $query->orderBy('name', $order);
        });
    }

    /**
     * Set filter columns
     *
     * @param $dataTable
     */
    protected function setFilterColumns($dataTable)
    {
        $dataTable->filterColumn('fullname', static function ($query, $keyword) {
            $query->where('firstname', 'like', "%$keyword%")
                ->orWhere('lastname', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('username', static function ($query, $keyword) {
            $query->where('username', 'like', "%$keyword%");
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
        $query = $model->newQuery();
        $query->with('distributors');
        $query->where('master', false);
        $query->whereHas("roles", function ($q) {
            $q->where("name", "distributor");
        });

        if ((\Auth::user())->hasRole(UserRole::DISTRIBUTOR)) {
            $distributor = (\Auth::user())->distributors()->where('status', true)->first();
            $query->whereHas('distributors', function ($q) use ($distributor) {
                $q->where('distributors.id', $distributor->id);
            });
        }

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('distributors-users-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrtip')
            ->orderBy(1)
            ->lengthMenu(config('admin.datatable.length_menu'))
            ->pageLength(config('admin.datatable.page_length'))
            ->buttons(
                Button::make('excel'),
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
            Column::make('fullname')->title(__('Full Name')),
            Column::make('username')->title(__('User Name')),
            Column::make('email')->orderable(false),
            Column::make('distributor')->orderable(false),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(110)
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
        return 'DistributorUsers_' . date('YmdHis');
    }
}
