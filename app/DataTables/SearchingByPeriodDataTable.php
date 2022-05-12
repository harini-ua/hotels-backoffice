<?php

namespace App\DataTables;

use App\Models\Company;
use Carbon\Carbon;
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
            return 23;
        });

        $dataTable->addColumn('first_period_bookings', function (Company $model) {
            return 60;
        });

        // ----- ----- ----- ----- ----- SECOND PERIOD  ----- ----- ----- ----- -----

        $dataTable->addColumn('second_period_users', function (Company $model) {
            return 67;
        });

        $dataTable->addColumn('second_period_bookings', function (Company $model) {
            return 93;
        });

        $this->setOrderColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('company')) {
                $query->where('id', $this->request->get('company'));
            }
            if ($this->request->has('period-first')) {
                $dates = explode(' - ', $this->request->get('period-first'));
                foreach ($dates as $key => $date) {
                    $dates[$key] = Carbon::parse($date);
                }
                // TODO: Need Implement
            }
            if ($this->request->has('period-second')) {
                $dates = explode(' - ', $this->request->get('period-second'));
                foreach ($dates as $key => $date) {
                    $dates[$key] = Carbon::parse($date);
                }
                // TODO: Need Implement
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
            ->orderBy(0)
            ->parameters([
                'columnDefs' => [
                    ['targets' => [0, 2], 'className' => 'border-right'],
                ]
            ])
            ->fixedHeader([
                'header' => true,
                'footer' => true,
                'headerOffset' => 55
            ])
            ->drawCallback("function () {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ? i.replace(/[\$,]/g, '')*1 : typeof i === 'number' ? i : 0;
                };

                total = api.column(1).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(1).footer()).html('('+ total +')');

                total = api.column(2).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(2).footer()).html('('+ total +')');

                total = api.column(3).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(3).footer()).html('('+ total +')');

                total = api.column(4).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(4).footer()).html('('+ total +')');
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
                ->titleAttr(__('Users'))
                ->addClass('text-center')
                ->width(150)
                ->orderable(false),
            Column::make('first_period_bookings')
                ->title('<i class="fa fa-bed"></i> '.__('Bookings'))
                ->titleAttr(__('Bookings'))
                ->addClass('text-center border-right')
                ->width(150)
                ->orderable(false),
            Column::make('second_period_users')
                ->title('<i class="fa fa-users"></i> '.__('Users'))
                ->titleAttr(__('Users'))
                ->addClass('text-center')
                ->width(150)
                ->orderable(false),
            Column::make('second_period_bookings')
                ->title('<i class="fa fa-bed"></i> '.__('Bookings'))
                ->titleAttr(__('Bookings'))
                ->addClass('text-center')
                ->width(150)
                ->orderable(false),
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
