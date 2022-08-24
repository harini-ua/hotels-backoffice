<?php

namespace App\DataTables;

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportBookingCommissionAdvancedDataTable extends DataTable
{
    /**
     * @var array $datePeriod
     */
    public $datePeriod = [];

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
            return view('admin.datatables.view-voucher', ['model' => $model]);
        });

        $dataTable->addColumn('id', function (Booking $model) {
            return $model->id;
        });

        $dataTable->addColumn('checkin', function (Booking $model) {
            return Formatter::date($model->checkin);
        });

        $dataTable->addColumn('checkout', function (Booking $model) {
            return Formatter::date($model->checkout);
        });

        $dataTable->addColumn('country', function (Booking $model) {
            return $model->country ? $model->country->name : '-';
        });

        $dataTable->addColumn('city', function (Booking $model) {
            return $model->city ? $model->city->name : '-';
        });

        $dataTable->addColumn('hotel', function (Booking $model) {
            return $model->hotel->name;
        });

        $dataTable->addColumn('company', function (Booking $model) {
            return $model->company->company_name;
        });

        $dataTable->addColumn('booking_user_id', function (Booking $model) {
            return $model->booking_user_id;
        });

        $dataTable->addColumn('vat_country', function (Booking $model) {
            $vat = $model->company->vats()
                ->where('country_id', $model->company->country_id)
                ->first();

            return $vat ? $vat->country->name : '-';
        });

        $dataTable->addColumn('vat_citizen', function (Booking $model) {
            $vat = $model->company->vats()
                ->where('country_id', $model->company->country_id)
                ->first();

            return $vat ? $vat->citizen->name : '-';
        });

        $dataTable->addColumn('total_price', function (Booking $model) {
            return $model->partner_amount ?? $model->amount;
        });

        $dataTable->addColumn('currency_for_total_price', function (Booking $model) {
            return $model->partner_currency_id ? $model->partner_currency->code : $model->original_currency->code;
        });

        $dataTable->addColumn('status', function (Booking $model) {
            return BookingStatus::getDescription($model->status);
        });

        $dataTable->addColumn('partner', function (Booking $model) {
            return $model->partner_amount && $model->partner_currency_id
                ? __('YES') : __('NO');
        });

        $dataTable->addColumn('create', function (Booking $model) {
            return Formatter::date($model->created_at);
        });

        $dataTable->addColumn('amount_conversion', function (Booking $model) {
            return round($model->amount_conversion, 2);
        });

        $dataTable->addColumn('currency_for_amount_conversion', function (Booking $model) {
            return $model->original_currency->code;
        });

        $dataTable->addColumn('commission', function (Booking $model) {
            return $model->commission;
        });

        $dataTable->addColumn('currency_for_commission', function (Booking $model) {
            return $model->original_currency->code;
        });

        $dataTable->addColumn('vat', function (Booking $model) {
            return round($model->vat, 2);
        });

        $dataTable->addColumn('currency_for_vat', function (Booking $model) {
            return $model->original_currency->code;
        });

        $dataTable->addColumn('pay_to_client', function (Booking $model) {
            return round($model->pay_to_client, 2);
        });

        $dataTable->addColumn('currency_for_pay_to_client', function (Booking $model) {
            return $model->original_currency->code;
        });

        $dataTable->addColumn('sales_office_commission', function (Booking $model) {
            return round($model->sales_office_commission, 2);
        });

        $dataTable->addColumn('currency_for_sales_office_commission', function (Booking $model) {
            return $model->original_currency->code;
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('status')) {
                $query->where('status', $this->request->get('status'));
            }
            if ($this->request->has('company')) {
                $query->where('company_id', $this->request->get('company'));
            }
            if ($this->request->has('check_in')) {
                $dates = explode(' - ', $this->request->get('check_in'));
                foreach ($dates as $key => $date) {
                    $this->datePeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
                }

                $query->whereDate('checkin', '>=', $this->datePeriod[0]);
                $query->whereDate('checkout', '<=', $this->datePeriod[1]);
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
        $dataTable->orderColumn('id', static function ($query, $order) {
            $query->orderBy('id', $order);
        });

        $dataTable->orderColumn('checkin', static function ($query, $order) {
            $query->orderBy('checkin', $order);
        });

        $dataTable->orderColumn('checkout', static function ($query, $order) {
            $query->orderBy('checkout', $order);
        });

        $dataTable->orderColumn('total_price', static function ($query, $order) {
            $query->orderBy('amount', $order);
        });

        $dataTable->orderColumn('status', static function ($query, $order) {
            $query->orderBy('status', $order);
        });

        $dataTable->orderColumn('partner', static function ($query, $order) {
            $query->orderByRaw('IF (`partner_currency_id`, 1, 0) '.$order);
        });

        $dataTable->orderColumn('create', static function ($query, $order) {
            $query->orderBy('created_at', $order);
        });

        $dataTable->orderColumn('amount_conversion', static function ($query, $order) {
            $query->orderBy('amount_conversion', $order);
        });

        $dataTable->orderColumn('commission', static function ($query, $order) {
            $query->orderBy('commission', $order);
        });

        $dataTable->orderColumn('vat', static function ($query, $order) {
            $query->orderBy('vat', $order);
        });

        $dataTable->orderColumn('pay_to_client', static function ($query, $order) {
            $query->orderBy('pay_to_client', $order);
        });

        $dataTable->orderColumn('sales_office_commission', static function ($query, $order) {
            $query->orderBy('sales_office_commission', $order);
        });
    }

    /**
     * Set filter columns
     *
     * @param $dataTable
     */
    protected function setFilterColumns($dataTable)
    {
        $dataTable->filterColumn('booking_id', static function ($query, $keyword) {
            $query->where('booking_reference', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('id', static function ($query, $keyword) {
            $query->where('id', 'like', "%$keyword%");
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
        $query->with('bookingUser.country');
        $query->with('discountCode');

        if (!$this->request->has('advanced_filter')) {
            $query->where('id', 0);
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
            ->dom('lrtip')
            ->orderBy(2)
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
            Column::make('booking_id')->title(__('Booking ID'))
                ->width(150)
                ->orderable(false),
            Column::make('id')->title(__('ID'))->addClass('text-center'),
            Column::make('checkin')->title(__('Check In'))
                ->addClass('text-center'),
            Column::make('checkout')->title(__('Check Out'))
                ->addClass('text-center'),
            Column::make('country')->title(__('Country'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('city')->title(__('City'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('hotel')->title(__('Hotel'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('company')->title(__('Company'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('booking_user_id')->title(__('Booking User ID'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('vat_country')->title(__('Country'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('vat_citizen')->title(__('Citizen'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('total_price')->title(__('Total Price'))
                ->addClass('text-center'),
            Column::make('currency_for_total_price')->title(__('Currency'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('status')->title(__('Status'))
                ->addClass('text-center'),
            Column::make('partner')->title(__('Partners Booking'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('create')->title(__('Requested Date'))
                ->addClass('text-center'),
            Column::make('amount_conversion')->title(__('Original Cost'))
                ->addClass('text-center'),
            Column::make('currency_for_amount_conversion')->title(__('Currency'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('commission')->title(__('Booking Commission'))
                ->addClass('text-center'),
            Column::make('currency_for_commission')->title(__('Currency'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('vat')->title(__('Booking VAT'))
                ->addClass('text-center'),
            Column::make('currency_for_vat')->title(__('Currency'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('pay_to_client')->title(__('Pay To Client'))
                ->addClass('text-center'),
            Column::make('currency_for_pay_to_client')->title(__('Currency'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('sales_office_commission')->title(__('Sales Office Commissions'))
                ->addClass('text-center'),
            Column::make('currency_for_sales_office_commission')->title(__('Currency'))
                ->addClass('text-center')
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
        return 'ReportBookingCommissionAdvanced_' . date('YmdHis');
    }
}
