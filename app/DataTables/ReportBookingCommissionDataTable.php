<?php

namespace App\DataTables;

use App\Enums\AllowedCurrency;
use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Country;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportBookingCommissionDataTable extends DataTable
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
            return (trim($model->inoffcode) !== "") ? $model->inn_off_code.'-'.$model->booking_reference : $model->booking_reference;
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

        $dataTable->addColumn('client_name', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('client_country', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('amount_charged', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('partners_booking', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('fixed_amount', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('total_commission', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('company_commission', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('sub_company_commission', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('vat', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('commission_level_1_1', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('commission_level_1_2', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('commission_level_2_1', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('commission_level_2_2', function (Booking $model) {
            return '?';
        });

        $dataTable->addColumn('currency', function (Booking $model) {
            $isAllowedCurrency = in_array($model->currency->code, AllowedCurrency::getValues(), true);
            return  $model->currency->code;
        });

        $dataTable->addColumn('status', function (Booking $model) {
            return BookingStatus::getDescription($model->status);
        });

        $dataTable->addColumn('payment', function (Booking $model) {
            return __('Paid');
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

        $dataTable->orderColumn('client_name', static function ($query, $order) {
            $query->orderBy('client_name', $order);
        });

        $dataTable->orderColumn('client_country', static function ($query, $order) {
            $query->orderBy('client_country', $order);
        });

        $dataTable->orderColumn('amount_charged', static function ($query, $order) {
            $query->orderBy('amount_charged', $order);
        });

        $dataTable->orderColumn('partners_booking', static function ($query, $order) {
            $query->orderBy('partners_booking', $order);
        });

        $dataTable->orderColumn('fixed_amount', static function ($query, $order) {
            $query->orderBy('fixed_amount', $order);
        });

        $dataTable->orderColumn('total_commission', static function ($query, $order) {
            $query->orderBy('total_commission', $order);
        });

        $dataTable->orderColumn('company_commission', static function ($query, $order) {
            $query->orderBy('company_commission', $order);
        });

        $dataTable->orderColumn('sub_company_commission', static function ($query, $order) {
            $query->orderBy('sub_company_commission', $order);
        });

        $dataTable->orderColumn('vat', static function ($query, $order) {
            $query->orderBy('vat', $order);
        });

        $dataTable->orderColumn('commission_level_1_1', static function ($query, $order) {
            $query->orderBy('commission_level_1_1', $order);
        });

        $dataTable->orderColumn('commission_level_1_2', static function ($query, $order) {
            $query->orderBy('commission_level_1_2', $order);
        });

        $dataTable->orderColumn('commission_level_2_1', static function ($query, $order) {
            $query->orderBy('commission_level_2_1', $order);
        });

        $dataTable->orderColumn('commission_level_2_2', static function ($query, $order) {
            $query->orderBy('commission_level_2_2', $order);
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

        $query->with('provider');
        $query->with('city');
        $query->with('country');
        $query->with('hotel');
        $query->with('bookingUser');
        $query->with('currency');
        $query->with('discountCode');

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
            ->setTableId('report-booking-commission-list-datatable')
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
            Column::make('client_name')->title(__('Client Name')),
            Column::make('client_country')->title(__('Client Country')),
            Column::make('amount_charged')->title(__('Total Amount Charged')),
            Column::make('partners_booking')->title(__('Partners Booking')),
            Column::make('fixed_amount')->title(__('Fixed Amount')),
            Column::make('total_commission')->title(__('Total Comm.')),
            Column::make('company_commission')->title(__('Comm. Company')),
            Column::make('sub_company_commission')->title(__('Comm. Sub-Company')),
            Column::make('vat')->title(__('VAT')),
            Column::make('commission_level_1_1')->title(__('Comm. Level 1-1')),
            Column::make('commission_level_1_2')->title(__('Comm. Level 1-2')),
            Column::make('commission_level_2_1')->title(__('Comm. Level 2-1')),
            Column::make('commission_level_2_2')->title(__('Comm. Level 2-2')),
            Column::make('currency')->title(__('Currency')),
            Column::make('status')->title(__('Status')),
            Column::make('payment')->title(__('Payment')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ReportBookingCommission_' . date('YmdHis');
    }
}
