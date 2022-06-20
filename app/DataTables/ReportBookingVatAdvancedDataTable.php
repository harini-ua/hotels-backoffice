<?php

namespace App\DataTables;

use App\Enums\AllowedCurrency;
use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportBookingVatAdvancedDataTable extends DataTable
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
            return view('admin.datatables.view-voucher', ['model' => $model]);
        });

        $dataTable->addColumn('hei_id', function (Booking $model) {
            return 'HEI'.$model->id;
        });

        $dataTable->addColumn('checkin', function (Booking $model) {
            return Formatter::date($model->checkin);
        });

        $dataTable->addColumn('checkout', function (Booking $model) {
            return Formatter::date($model->checkout);
        });

        $dataTable->addColumn('city', function (Booking $model) {
            return $model->city ? $model->city->name : '-';
        });

        $dataTable->addColumn('country', function (Booking $model) {
            return $model->country ? $model->country->name : '-';
        });

        $dataTable->addColumn('hotel', function (Booking $model) {
            return $model->hotel->name;
        });

        $dataTable->addColumn('client_name', function (Booking $model) {
            return $model->customer_name;
        });

        $dataTable->addColumn('client_country', function (Booking $model) {
            return $model->bookingUser->country->name;
        });

        $dataTable->addColumn('status', function (Booking $model) {
            return BookingStatus::getDescription($model->status);
        });

        $dataTable->addColumn('payment', function (Booking $model) {
            return __('Paid');
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
            if ($this->request->has('order_id')) {
                $query->where('booking_reference', $this->request->get('order_id'));
            }
            if ($this->request->has('booking_id')) {
                $query->where('id', $this->request->get('booking_id'));
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
        $dataTable->orderColumn('hei_id', static function ($query, $order) {
            $query->orderBy('id', $order);
        });

        $dataTable->orderColumn('checkin', static function ($query, $order) {
            $query->orderBy('checkin', $order);
        });

        $dataTable->orderColumn('checkout', static function ($query, $order) {
            $query->orderBy('checkout', $order);
        });

        $dataTable->orderColumn('client_name', static function ($query, $order) {
            $query->orderBy('client_name', $order);
        });

        $dataTable->orderColumn('client_country', static function ($query, $order) {
            $query->orderBy('client_country', $order);
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
            // TODO: Need Implement
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

        if ($this->request->has('quick_filter')) {
            if ($this->request->has('check_in')) {
                $dates = explode(' - ', $this->request->get('check_in'));
                foreach ($dates as $key => $date) {
                    $this->checkInPeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
                }
            }

            $query->whereDate('checkin', '>=', $this->checkInPeriod[0]);
            $query->whereDate('checkout', '<=', $this->checkInPeriod[1]);
        }
        elseif ($this->request->has('advanced_filter')) {
            if ($this->request->has('voucher_date')) {
                $dates = explode(' - ', $this->request->get('voucher_date'));
                foreach ($dates as $key => $date) {
                    $this->voucherDatePeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
                }
            }

            $query->whereBetween('created_at', $this->voucherDatePeriod);
        } else {
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
            ->setTableId('report-booking-vat-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtip')
            ->pageLength(50)
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
            Column::make('booking_id')->title(__('Booking ID'))
                ->width(150)
                ->orderable(false),
            Column::make('hei_id')->title(__('HEI ID'))->addClass('text-center'),
            Column::make('checkin')->title(__('Arrival Date'))
                ->addClass('text-center'),
            Column::make('checkout')->title(__('Departure Date'))
                ->addClass('text-center'),
            Column::make('city')->title(__('City'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('country')->title(__('Country'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('hotel')->title(__('Hotel'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('client_name')->title(__('Client Name'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('client_country')->title(__('Client Country'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('status')->title(__('Status'))
                ->addClass('text-center'),
            Column::make('payment')->title(__('Payment'))
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
        return 'ReportBookingVat_' . date('YmdHis');
    }
}
