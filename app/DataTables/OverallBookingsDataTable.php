<?php

namespace App\DataTables;

use App\Models\Company;
use App\Services\Formatter;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class OverallBookingsDataTable extends DataTable
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

        $dataTable->addColumn('created_at', function (Company $model) {
            return Formatter::date($model->created_at);
        });

        $dataTable->addColumn('company_name', function (Company $model) {
            return $model->company_name;
        });

        $dataTable->addColumn('total_users', function (Company $model) {
            return 6;
        });

        $dataTable->addColumn('total_bookings', function (Company $model) {
            return 280;
        });

        // ----- ----- ----- ----- ----- CURRENT YEAR  ----- ----- ----- ----- -----

        $dataTable->addColumn('current_today_bookings', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('current_today_users', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('current_week_bookings', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('current_week_users', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('current_month_bookings', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('current_month_users', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('current_year_bookings', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('current_year_users', function (Company $model) {
            return 0;
        });

        // ----- ----- ----- ----- ----- PREVIOUS YEAR  ----- ----- ----- ----- -----

        $dataTable->addColumn('previous_today_bookings', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('previous_today_users', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('previous_week_bookings', function (Company $model) {
            return 10;
        });

        $dataTable->addColumn('previous_week_users', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('previous_month_bookings', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('previous_month_users', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('previous_year_bookings', function (Company $model) {
            return 0;
        });

        $dataTable->addColumn('previous_year_users', function (Company $model) {
            return 0;
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
        $dataTable->orderColumn('company_name', static function ($query, $order) {
            $query->orderBy('company_name', $order);
        });

        $dataTable->orderColumn('total_users', static function ($query, $order) {
            // TODO: Need Implement
        });

        $dataTable->orderColumn('total_bookings', static function ($query, $order) {
            // TODO: Need Implement
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
            ->setTableId('overall-bookings-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtip')
            ->orderBy(1)
            ->parameters([
                'columnDefs' => [
                    ['targets' => [3, 11], 'className' => 'border-right-custom'],
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

                total = api.column(2).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(2).footer()).html('('+ total +')');

                total = api.column(3).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(3).footer()).html('('+ total +')');

                total = api.column(4).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(4).footer()).html('('+ total +')');

                total = api.column(5).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(5).footer()).html('('+ total +')');

                total = api.column(6).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(6).footer()).html('('+ total +')');

                total = api.column(7).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(7).footer()).html('('+ total +')');

                total = api.column(8).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(8).footer()).html('('+ total +')');

                total = api.column(9).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(9).footer()).html('('+ total +')');

                total = api.column(10).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(10).footer()).html('('+ total +')');

                total = api.column(11).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(11).footer()).html('('+ total +')');

                total = api.column(12).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(12).footer()).html('('+ total +')');

                total = api.column(13).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(13).footer()).html('('+ total +')');

                total = api.column(14).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(14).footer()).html('('+ total +')');

                total = api.column(15).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(15).footer()).html('('+ total +')');

                total = api.column(16).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(16).footer()).html('('+ total +')');

                total = api.column(17).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(17).footer()).html('('+ total +')');

                total = api.column(18).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(18).footer()).html('('+ total +')');

                total = api.column(19).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(19).footer()).html('('+ total +')');
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
            Column::make('created_at')->title(__('Reg date')),
            Column::make('company_name')->title(__('Company Site')),
            Column::make('total_users')
                ->title(__('Total Users'))
                ->addClass('text-center')
                ->footer('<b class="total_users">(0)</b>'),
            Column::make('total_bookings')
                ->title(__('Total Bookings'))
                ->addClass('text-center')
                ->footer('<b class="total_bookings">(0)</b>'),
            Column::make('current_today_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->footer('<b class="total_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_today_users')
                ->title('<i class="fa fa-users"></i>')
                ->footer('<b class="current_today_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_week_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->footer('<b class="current_week_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_week_users')
                ->title('<i class="fa fa-users"></i>')
                ->footer('<b class="current_week_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_month_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->footer('<b class="current_month_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_month_users')
                ->title('<i class="fa fa-users"></i>')
                ->footer('<b class="current_month_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_year_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->footer('<b class="current_year_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_year_users')
                ->title('<i class="fa fa-users"></i>')
                ->footer('<b class="current_year_users">(0)</b>')
                ->addClass('text-center')->orderable(false),

            Column::make('previous_today_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->footer('<b class="current_year_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_today_users')
                ->title('<i class="fa fa-users"></i>')
                ->footer('<b class="previous_today_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_week_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->footer('<b class="previous_week_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_week_users')
                ->title('<i class="fa fa-users"></i>')
                ->footer('<b class="previous_week_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_month_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->footer('<b class="previous_month_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_month_users')
                ->title('<i class="fa fa-users"></i>')
                ->footer('<b class="previous_month_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_year_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->footer('<b class="previous_year_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_year_users')
                ->title('<i class="fa fa-users"></i> ')
                ->footer('<b class="previous_year_users">(0)</b>')
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
        return 'OverallBookings_' . date('YmdHis');
    }
}
