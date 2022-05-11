<?php

namespace App\DataTables;

use App\Models\Company;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SearchingByPeriodDataTable extends DataTable
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

        $dataTable->addColumn('company_name', function (Company $model) {
            return $model->company_name;
        });

        // ----- ----- ----- ----- ----- FIRST PERIOD  ----- ----- ----- ----- -----

        $dataTable->addColumn('first_period_users', function (Company $model) {
            return '-';
        });

        $dataTable->addColumn('first_period_bookings', function (Company $model) {
            return '-';
        });

        // ----- ----- ----- ----- ----- SECOND PERIOD  ----- ----- ----- ----- -----

        $dataTable->addColumn('second_period_users', function (Company $model) {
            return '-';
        });

        $dataTable->addColumn('second_period_bookings', function (Company $model) {
            return '-';
        });

        $this->setOrderColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('company')) {
                $query->where('id', $this->request->get('company'));
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
        //..
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Company $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Company $model)
    {
        return $model->newQuery()
            ->with(['users'])
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
            ->setTableId('searching-period-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtip')
            ->orderBy(1)
            ->parameters([
                'columnDefs' => [
                    //
                ]
            ])
            ->drawCallback("function() {

            }")
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
            Column::make('company_name')->title(__('Company Site')),

            Column::make('first_period_users')
                ->title('<i class="fa fa-users"></i> '.__('Users'))
                ->addClass('text-center')->orderable(false),
            Column::make('first_period_bookings')
                ->title('<i class="fa fa-bed"></i> '.__('Bookings'))
                ->addClass('text-center')->orderable(false),
            Column::make('second_period_users')
                ->title('<i class="fa fa-users"></i> '.__('Users'))
                ->addClass('text-center')->orderable(false),
            Column::make('second_period_bookings')
                ->title('<i class="fa fa-bed"></i> '.__('Bookings'))
                ->addClass('text-center')->orderable(false),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'SearchingPeriod_' . date('YmdHis');
    }
}
