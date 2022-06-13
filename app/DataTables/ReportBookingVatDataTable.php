<?php

namespace App\DataTables;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Country;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportBookingVatDataTable extends DataTable
{
    /**
     * @var array $checkInPeriod
     */
    public $checkInPeriod = [];

    /**
     * @var array $voucherDatePeriod
     */
    public $voucherDatePeriod = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('booking_id', function (Booking $model) {
            return ($model->inn_off_code) ? $model->inn_off_code.'-'.$model->booking_reference : $model->booking_reference;
        });

        $dataTable->addColumn('hei_id', function (Booking $model) {
            return $model->id;
        });

        $dataTable->addColumn('checkin', function (Booking $model) {
            return Formatter::date($model->checkin);
        });

        $dataTable->addColumn('checkout', function (Booking $model) {
            return Formatter::date($model->checkout);
        });

        $dataTable->addColumn('city', function (Booking $model) {
            return $model->city->name;
        });

        $dataTable->addColumn('country', function (Booking $model) {
            return $model->country->name;
        });

        $dataTable->addColumn('hotel', function (Booking $model) {
            return $model->hotel->name;
        });

        $dataTable->addColumn('status', function (Booking $model) {
            return BookingStatus::getDescription($model->status);
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        return $dataTable;
    }

    /**
     * Set order columns
     *
     * @param $dataTable
     */
    protected function setOrderColumns($dataTable)
    {
        $dataTable->orderColumn('id', static function ($query, $order) {
            $query->orderBy('id', $order);
        });

        $dataTable->orderColumn('status', static function ($query, $order) {
            $query->orderBy('status', $order);
        });
    }

    /**
     * Set filter columns
     *
     * @param $dataTable
     */
    protected function setFilterColumns($dataTable)
    {
        $dataTable->filterColumn('name', static function ($query, $keyword) {

        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Booking $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Booking $model)
    {
        $query = $model->newQuery();

        $query->with('city');
        $query->with('country');
        $query->with('hotel');

        $query->where('country_id', 0);

        if ($this->request->has('check_in')) {
            $dates = explode(' - ', $this->request->get('check_in'));
            foreach ($dates as $key => $date) {
                $this->checkInPeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
            }
        }

        if ($this->request->has('voucher_date')) {
            $dates = explode(' - ', $this->request->get('voucher_date'));
            foreach ($dates as $key => $date) {
                $this->voucherDatePeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
            }
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
            ->setTableId('report-booking-vat-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Brti')
            ->pageLength(Country::all()->count())
            ->orderBy(0, 'desc')
            ->language([
                'search' => '',
                'searchPlaceholder' => __('Search')
            ])
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
            Column::make('booking_id')->title(__('Booking ID')),
            Column::make('hei_id')->title(__('HEI ID')),
            Column::make('city')->title(__('City')),
            Column::make('country')->title(__('Country')),
            Column::make('hotel')->title(__('Hotel')),
            Column::make('status')->title(__('Status')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ReportBookingVat_' . date('YmdHis');
    }
}
