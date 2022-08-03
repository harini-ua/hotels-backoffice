<?php

namespace App\DataTables;

use App\Models\Booking;
use App\Models\BookingUser;
use App\Models\Company;
use App\Models\CompanyBookingUser;
use App\Services\Formatter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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
            return $model->created_at ? Formatter::date($model->created_at) : '-';
        });

        $dataTable->addColumn('company_name', function (Company $model) {
            return $model->company_name;
        });

        $dataTable->addColumn('total_users', function (Company $model) {
            return $model->total_users;
        });

        $dataTable->addColumn('total_bookings', function (Company $model) {
            return $model->total_bookings;
        });

        // ----- ----- ----- ----- ----- CURRENT YEAR  ----- ----- ----- ----- -----

        $dataTable->addColumn('current_today_bookings', function (Company $model) {
            return $model->current_today_bookings;
        });

        $dataTable->addColumn('current_today_users', function (Company $model) {
            return $model->current_today_users;
        });

        $dataTable->addColumn('current_week_bookings', function (Company $model) {
            return $model->current_week_bookings;
        });

        $dataTable->addColumn('current_week_users', function (Company $model) {
            return $model->current_week_users;
        });

        $dataTable->addColumn('current_month_bookings', function (Company $model) {
            return $model->current_month_bookings;
        });

        $dataTable->addColumn('current_month_users', function (Company $model) {
            return $model->current_month_users;
        });

        $dataTable->addColumn('current_year_bookings', function (Company $model) {
            return $model->current_year_bookings;
        });

        $dataTable->addColumn('current_year_users', function (Company $model) {
            return $model->current_year_users;
        });

        // ----- ----- ----- ----- ----- PREVIOUS YEAR  ----- ----- ----- ----- -----

        $dataTable->addColumn('previous_today_bookings', function (Company $model) {
            return $model->previous_today_bookings;
        });

        $dataTable->addColumn('previous_today_users', function (Company $model) {
            return $model->previous_today_users;
        });

        $dataTable->addColumn('previous_week_bookings', function (Company $model) {
            return $model->previous_week_bookings;
        });

        $dataTable->addColumn('previous_week_users', function (Company $model) {
            return $model->previous_week_users;
        });

        $dataTable->addColumn('previous_month_bookings', function (Company $model) {
            return $model->previous_month_bookings;
        });

        $dataTable->addColumn('previous_month_users', function (Company $model) {
            return $model->previous_month_users;
        });

        $dataTable->addColumn('previous_year_bookings', function (Company $model) {
            return $model->previous_year_bookings;
        });

        $dataTable->addColumn('previous_year_users', function (Company $model) {
            return $model->previous_year_users;
        });

        $this->setOrderColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('company')) {
                $query->where('companies.id', $this->request->get('company'));
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
            $query->orderBy('total_users', $order);
        });

        $dataTable->orderColumn('total_bookings', static function ($query, $order) {
            $query->orderBy('total_bookings', $order);
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
        $query = $model->newQuery();
        $query->select([
            'companies.id'
            , 'companies.company_name'
            , 'companies.created_at'
        ]);

        $query->leftJoin(CompanyBookingUser::TABLE_NAME, 'companies.id', '=', 'company_booking_user.company_id');
        $query->leftJoin(BookingUser::TABLE_NAME, 'company_booking_user.booking_user_id', '=', 'booking_users.id');
        $query->leftJoin(Booking::TABLE_NAME, 'booking_users.id', '=', 'bookings.user_id');

        // Total users by company
        $query->selectRaw('IFNULL(total_user.count, 0) AS total_users');

        $total_user = DB::table(CompanyBookingUser::TABLE_NAME)
            ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
            ->groupBy('company_id');

        $query->leftJoinSub($total_user, 'total_user', static function($join) {
            $join->on('company_booking_user.company_id', '=', 'total_user.company_id');
        });

        // Total bookings by company
        $query->selectRaw('IFNULL(total_booking.count, 0) AS total_bookings');

        $total_booking = DB::table(Booking::TABLE_NAME)
            ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
        ;

        $query->leftJoinSub($total_booking, 'total_booking', static function($join) {
            $join->on('bookings.user_id', '=', 'total_booking.user_id');
        });

        $this->addCurrentYearUserSubSelect($query);
        $this->addCurrentYearBookingSubSelect($query);

        $this->addPreviousYearUserSubSelect($query);
        $this->addPreviousYearBookingSubSelect($query);

        $query->groupBy('companies.id');

        return $query;
    }

    private function addCurrentYearUserSubSelect($query)
    {
        // Get total users today by company

        $query->selectRaw('IFNULL(current_today_user.count, 0) AS current_today_users');

        $current_today_user = DB::table(CompanyBookingUser::TABLE_NAME)
            ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
            ->whereDate('created_at', Carbon::now())
            ->groupBy('company_id');

        $query->leftJoinSub($current_today_user, 'current_today_user', static function($join) {
            $join->on('company_booking_user.company_id', '=', 'current_today_user.company_id');
        });

        // Get total users this week by company

        $query->selectRaw('IFNULL(current_week_user.count, 0) AS current_week_users');

        $current_week_user = DB::table(CompanyBookingUser::TABLE_NAME)
            ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
            ->groupBy('company_id');

        $query->leftJoinSub($current_week_user, 'current_week_user', static function($join) {
            $join->on('company_booking_user.company_id', '=', 'current_week_user.company_id');
        });

        // Get total users this month by company

        $query->selectRaw('IFNULL(current_month_user.count, 0) AS current_month_users');

        $current_month_user = DB::table(CompanyBookingUser::TABLE_NAME)
            ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
            ->groupBy('company_id');

        $query->leftJoinSub($current_month_user, 'current_month_user', static function($join) {
            $join->on('company_booking_user.company_id', '=', 'current_month_user.company_id');
        });

        // Get total users this year by company

        $query->selectRaw('IFNULL(current_year_user.count, 0) AS current_year_users');

        $current_year_user = DB::table(CompanyBookingUser::TABLE_NAME)
            ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear()
            ])
            ->groupBy('company_id');

        $query->leftJoinSub($current_year_user, 'current_year_user', static function($join) {
            $join->on('company_booking_user.company_id', '=', 'current_year_user.company_id');
        });

    }

    private function addCurrentYearBookingSubSelect($query)
    {
        // Today in current year - total bookings by company

        $query->selectRaw('IFNULL(current_today_booking.count, 0) AS current_today_bookings');

        $current_today_booking = DB::table(Booking::TABLE_NAME)
            ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
            ->whereDate('created_at', Carbon::now())
        ;

        $query->leftJoinSub($current_today_booking, 'current_today_booking', static function($join) {
            $join->on('bookings.user_id', '=', 'current_today_booking.user_id');
        });

        // Week in current year - total bookings by company

        $query->selectRaw('IFNULL(current_week_booking.count, 0) AS current_week_bookings');

        $current_week_booking = DB::table(Booking::TABLE_NAME)
            ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
        ;

        $query->leftJoinSub($current_week_booking, 'current_week_booking', static function($join) {
            $join->on('bookings.user_id', '=', 'current_week_booking.user_id');
        });

        // Month in current year - total bookings by company

        $query->selectRaw('IFNULL(current_month_booking.count, 0) AS current_month_bookings');

        $current_month_booking = DB::table(Booking::TABLE_NAME)
            ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
        ;

        $query->leftJoinSub($current_month_booking, 'current_month_booking', static function($join) {
            $join->on('bookings.user_id', '=', 'current_month_booking.user_id');
        });

        // Year in current year - total bookings by company

        $query->selectRaw('IFNULL(current_year_booking.count, 0) AS current_year_bookings');

        $current_year_booking = DB::table(Booking::TABLE_NAME)
            ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear()
            ])
        ;

        $query->leftJoinSub($current_year_booking, 'current_year_booking', static function($join) {
            $join->on('bookings.user_id', '=', 'current_year_booking.user_id');
        });
    }

    private function addPreviousYearUserSubSelect($query)
    {
        // Get total users today by company

        $query->selectRaw('IFNULL(previous_today_user.count, 0) AS previous_today_users');

        $previous_today_user = DB::table(CompanyBookingUser::TABLE_NAME)
            ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
            ->whereDate('created_at', Carbon::now()->subYear())
            ->groupBy('company_id');

        $query->leftJoinSub($previous_today_user, 'previous_today_user', static function($join) {
            $join->on('company_booking_user.company_id', '=', 'previous_today_user.company_id');
        });

        // Get total users this week by company

        $query->selectRaw('IFNULL(previous_week_user.count, 0) AS previous_week_users');

        $previous_week_user = DB::table(CompanyBookingUser::TABLE_NAME)
            ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->subYear()->startOfWeek(),
                Carbon::now()->subYear()->endOfWeek()
            ])
            ->groupBy('company_id');

        $query->leftJoinSub($previous_week_user, 'previous_week_user', static function($join) {
            $join->on('company_booking_user.company_id', '=', 'previous_week_user.company_id');
        });

        // Get total users this month by company

        $query->selectRaw('IFNULL(previous_month_user.count, 0) AS previous_month_users');

        $previous_month_user = DB::table(CompanyBookingUser::TABLE_NAME)
            ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->subYear()->startOfMonth(),
                Carbon::now()->subYear()->endOfMonth()
            ])
            ->groupBy('company_id');

        $query->leftJoinSub($previous_month_user, 'previous_month_user', static function($join) {
            $join->on('company_booking_user.company_id', '=', 'previous_month_user.company_id');
        });

        // Get total users this year by company

        $query->selectRaw('IFNULL(previous_year_user.count, 0) AS previous_year_users');

        $previous_year_user = DB::table(CompanyBookingUser::TABLE_NAME)
            ->select(['company_id', DB::raw('COUNT(booking_user_id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->subYear()->startOfYear(),
                Carbon::now()->subYear()->endOfYear()
            ])
            ->groupBy('company_id');

        $query->leftJoinSub($previous_year_user, 'previous_year_user', static function($join) {
            $join->on('company_booking_user.company_id', '=', 'previous_year_user.company_id');
        });
    }

    private function addPreviousYearBookingSubSelect($query)
    {
        // Today in previous year - total bookings by company

        $query->selectRaw('IFNULL(previous_today_booking.count, 0) AS previous_today_bookings');

        $previous_today_booking = DB::table(Booking::TABLE_NAME)
            ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
            ->whereDate('created_at', Carbon::now())
        ;

        $query->leftJoinSub($previous_today_booking, 'previous_today_booking', static function($join) {
            $join->on('bookings.user_id', '=', 'previous_today_booking.user_id');
        });

        // Week in previous year - total bookings by company

        $query->selectRaw('IFNULL(previous_week_booking.count, 0) AS previous_week_bookings');

        $previous_week_booking = DB::table(Booking::TABLE_NAME)
            ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])
        ;

        $query->leftJoinSub($previous_week_booking, 'previous_week_booking', static function($join) {
            $join->on('bookings.user_id', '=', 'previous_week_booking.user_id');
        });

        // Month in previous year - total bookings by company

        $query->selectRaw('IFNULL(previous_month_booking.count, 0) AS previous_month_bookings');

        $previous_month_booking = DB::table(Booking::TABLE_NAME)
            ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfMonth(),
                Carbon::now()->endOfMonth()
            ])
        ;

        $query->leftJoinSub($previous_month_booking, 'previous_month_booking', static function($join) {
            $join->on('bookings.user_id', '=', 'previous_month_booking.user_id');
        });

        // Year in previous year - total bookings by company

        $query->selectRaw('IFNULL(previous_year_booking.count, 0) AS previous_year_bookings');

        $previous_year_booking = DB::table(Booking::TABLE_NAME)
            ->select(['user_id', DB::raw('COUNT(id) AS count'), 'created_at'])
            ->whereBetween('created_at', [
                Carbon::now()->startOfYear(),
                Carbon::now()->endOfYear()
            ])
        ;

        $query->leftJoinSub($previous_year_booking, 'previous_year_booking', static function($join) {
            $join->on('bookings.user_id', '=', 'previous_year_booking.user_id');
        });
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
            ->dom('lrtip')
            ->orderBy(1)
            ->lengthMenu(config('admin.datatable.length_menu'))
            ->pageLength(config('admin.datatable.page_length'))
            ->parameters([
                'columnDefs' => [
                    ['targets' => [3, 11], 'className' => 'border-right'],
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
                ->title(__('Total BookingSeeder'))
                ->addClass('text-center border-right')
                ->footer('<b class="total_bookings">(0)</b>'),
            Column::make('current_today_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->titleAttr(__('BookingSeeder'))
                ->footer('<b class="total_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_today_users')
                ->title('<i class="fa fa-users"></i>')
                ->titleAttr(__('Users'))
                ->footer('<b class="current_today_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_week_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->titleAttr(__('BookingSeeder'))
                ->footer('<b class="current_week_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_week_users')
                ->title('<i class="fa fa-users"></i>')
                ->titleAttr(__('Users'))
                ->footer('<b class="current_week_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_month_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->titleAttr(__('BookingSeeder'))
                ->footer('<b class="current_month_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_month_users')
                ->title('<i class="fa fa-users"></i>')
                ->titleAttr(__('Users'))
                ->footer('<b class="current_month_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_year_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->titleAttr(__('BookingSeeder'))
                ->footer('<b class="current_year_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('current_year_users')
                ->title('<i class="fa fa-users"></i>')
                ->titleAttr(__('Users'))
                ->footer('<b class="current_year_users">(0)</b>')
                ->addClass('text-center border-right')->orderable(false),

            Column::make('previous_today_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->titleAttr(__('BookingSeeder'))
                ->footer('<b class="current_year_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_today_users')
                ->title('<i class="fa fa-users"></i>')
                ->titleAttr(__('Users'))
                ->footer('<b class="previous_today_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_week_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->titleAttr(__('BookingSeeder'))
                ->footer('<b class="previous_week_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_week_users')
                ->title('<i class="fa fa-users"></i>')
                ->titleAttr(__('Users'))
                ->footer('<b class="previous_week_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_month_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->titleAttr(__('BookingSeeder'))
                ->footer('<b class="previous_month_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_month_users')
                ->title('<i class="fa fa-users"></i>')
                ->titleAttr(__('Users'))
                ->footer('<b class="previous_month_users">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_year_bookings')
                ->title('<i class="fa fa-bed"></i>')
                ->titleAttr(__('BookingSeeder'))
                ->footer('<b class="previous_year_bookings">(0)</b>')
                ->addClass('text-center')->orderable(false),
            Column::make('previous_year_users')
                ->title('<i class="fa fa-users"></i> ')
                ->titleAttr(__('Users'))
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
