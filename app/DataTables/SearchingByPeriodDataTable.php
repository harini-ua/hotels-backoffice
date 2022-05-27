<?php

namespace App\DataTables;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SearchingByPeriodDataTable extends DataTable
{
    public $firstPeriod = [];
    public $secondPeriod = [];

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
            return $model->first_period_users;
        });

        $dataTable->addColumn('first_period_bookings', function (Company $model) {
            return $model->first_period_bookings;
        });

        // ----- ----- ----- ----- ----- SECOND PERIOD  ----- ----- ----- ----- -----

        $dataTable->addColumn('second_period_users', function (Company $model) {
            return $model->second_period_users;
        });

        $dataTable->addColumn('second_period_bookings', function (Company $model) {
            return $model->second_period_bookings;
        });

        $this->setOrderColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('company')) {
                $query->where('companies.id', $this->request->get('company'));
            }

            if (!$this->request->hasAny(['period-first', 'period-second'])){
                // Making the result empty on purpose
                $query->where('companies.id', 0);
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
        if ($this->request->has('period-first')) {
            $dates = explode(' - ', $this->request->get('period-first'));
            foreach ($dates as $key => $date) {
                $this->firstPeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
            }
        }

        if ($this->request->has('period-second')) {
            $dates = explode(' - ', $this->request->get('period-second'));
            foreach ($dates as $key => $date) {
                $this->secondPeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
            }
        }

        $query = $model->newQuery();

        $query->select([
            'companies.id'
            , 'companies.company_name'
            , 'companies.created_at'
        ]);

        $query->leftJoin('company_booking_user', 'companies.id', '=', 'company_booking_user.company_id');
        $query->leftJoin('booking_users', 'company_booking_user.booking_user_id', '=', 'booking_users.id');
        $query->leftJoin('bookings', 'booking_users.id', '=', 'bookings.user_id');

        $this->addFirstPeriodSubSelect($query);
        $this->addSecondPeriodSubSelect($query);

        $query->groupBy('companies.id');

        return $query;
    }

    private function addFirstPeriodSubSelect($query)
    {
        if ($this->request->hasAny(['period-first', 'period-second'])) {

            // Get total users by first period
            $query->selectRaw('IFNULL(first_period_user.count, 0) AS first_period_users');

            $first_period_user = DB::table('company_booking_user')
                ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
                ->whereBetween('created_at', $this->firstPeriod)
                ->groupBy('company_id');

            $query->leftJoinSub($first_period_user, 'first_period_user', static function($join) {
                $join->on('company_booking_user.company_id', '=', 'first_period_user.company_id');
            });

            // Get total booking by first period
            $query->selectRaw('IFNULL(first_period_booking.count, 0) AS first_period_bookings');

            $first_period_booking = DB::table('bookings')
                ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
                ->whereBetween('created_at', $this->firstPeriod);

            $query->leftJoinSub($first_period_booking, 'first_period_booking', static function($join) {
                $join->on('bookings.user_id', '=', 'first_period_booking.user_id');
            });
        }
    }

    private function addSecondPeriodSubSelect($query)
    {
        if ($this->request->hasAny(['period-first', 'period-second'])) {

            // Get total users by second period
            $query->selectRaw('IFNULL(second_period_user.count, 0) AS second_period_users');

            $second_period_user = DB::table('company_booking_user')
                ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
                ->whereBetween('created_at', $this->secondPeriod)
                ->groupBy('company_id');

            $query->leftJoinSub($second_period_user, 'second_period_user', static function($join) {
                $join->on('company_booking_user.company_id', '=', 'second_period_user.company_id');
            });

            // Get total booking by second period
            $query->selectRaw('IFNULL(second_period_booking.count, 0) AS second_period_bookings');

            $second_period_booking = DB::table('bookings')
                ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
                ->whereBetween('created_at', $this->secondPeriod);

            $query->leftJoinSub($second_period_booking, 'second_period_booking', static function($join) {
                $join->on('bookings.user_id', '=', 'second_period_booking.user_id');
            });
        }
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

                total = api.column(0).data().reduce(function(a, b) { return a + 1; }, 0);
                $(api.column(0).footer()).html('Total: ('+ total +')');

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
                ->title('<i class="fa fa-bed"></i> '.__('BookingSeeder'))
                ->titleAttr(__('BookingSeeder'))
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
                ->title('<i class="fa fa-bed"></i> '.__('BookingSeeder'))
                ->titleAttr(__('BookingSeeder'))
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
