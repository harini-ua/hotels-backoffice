<?php

namespace App\DataTables;

use App\Enums\AllowedCurrency;
use App\Enums\BookingPlatform;
use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportBookingCustomerDataTable extends DataTable
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

        $dataTable->addColumn('booking_source', function (Booking $model) {
            return BookingPlatform::getDescription($model->platform_type);
        });

        $dataTable->addColumn('company', function (Booking $model) {
            return view('admin.datatables.view-link', [
                'model' => $model->company,
                'title' => $model->company->company_name,
                'action' => 'edit'
            ]);
        });

        $dataTable->addColumn('booking_user', function (Booking $model) {
            return view('admin.datatables.view-link', [
                'model' => $model->bookingUser,
                'title' => $model->bookingUser->fullname,
            ]);
        });

        $dataTable->addColumn('cancelled_date', function (Booking $model) {
            return Formatter::date($model->cancelled_date);
        });

        $dataTable->addColumn('created', function (Booking $model) {
            return Formatter::date($model->created_at);
        });

        $dataTable->addColumn('status', function (Booking $model) {
            return BookingStatus::getDescription($model->status);
        });

        $dataTable->addColumn('partner', function (Booking $model) {
            return __('No');
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->addColumn('total_price', function (Booking $model) {
                $totalPrice = 0;
                if ($model->amount > 0) {
                    $isAllowedCurrency = in_array($model->currency->code, AllowedCurrency::getValues(), true);
                    if ($isAllowedCurrency) {
                        $totalPrice = $model->amount / $model->conversion_rate;
                        $currency = $model->currency->code; // TODO: selectedcurrency
                    } else {
                        $totalPrice = $model->amount;
                        $currency = $model->currency->code; // TODO: currency_type
                    }

                    if ($model->company->partner) {
                        if ($model->company->mainOptions) {
                            $totalPrice = $model->company->mainOptions->max_price_filter;
                            $currency = $model->company->mainOptions->currencyFilter->code;
                        }
                    }

                    $totalPrice = round($totalPrice, 2);
                }

                return $totalPrice;
            });

            $dataTable->addColumn('currency', function (Booking $model) {
                if ($model->amount > 0) {
                    $isAllowedCurrency = in_array($model->currency->code, AllowedCurrency::getValues(), true);

                    if ($isAllowedCurrency) {
                        $currency = $model->currency->code; // TODO: selectedcurrency
                    } else {
                        $currency = $model->currency->code; // TODO: currency_type
                    }

                    if ($model->company->partner) {
                        if ($model->company->mainOptions) {
                            $currency = $model->company->mainOptions->currencyFilter->code;
                        }
                    }
                }

                // TODO: $model->partner_currency_type ?? $currency
                return $currency;
            });
        }

        $dataTable->addColumn('commission', function (Booking $model) {
            return $model->commission ?? 0;
        });

        $dataTable->addColumn('currency_for_commission', function (Booking $model) {
            return $model->currency->code;
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->addColumn('vat', function (Booking $model) {
                return $model->vat ? round($model->vat, 2) : 0;
            });

            $dataTable->addColumn('currency_for_vat', function (Booking $model) {
                return $model->currency->code;
            });
        }

        $dataTable->addColumn('pay_to_client', function (Booking $model) {
            return $model->pay_to_client ? round($model->pay_to_client, 2) : 0;
        });

        $dataTable->addColumn('currency_for_pay_to_client', function (Booking $model) {
            return $model->currency->code;
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->addColumn('sales_office_commission', function (Booking $model) {
                return $model->sales_office_commission ? round($model->sales_office_commission, 2) : 0;
            });

            $dataTable->addColumn('currency_for_sales_office_commission', function (Booking $model) {
                return $model->currency->code;
            });
        }


        $dataTable->addColumn('payment', function (Booking $model) {
            // TODO: $model->full_discount
            if (true && $model->amount > 0) {
                return view("admin.datatables.actions", [
                    'actions' => ['payment'],
                    'model' => $model,
                    'route' => route('payment.booking', $model),
                ]);
            }

            return view("admin.datatables.actions", [
                'actions' => ['payment'],
                'model' => $model,
                'route' => route('payment.booking', $model),
            ]);

            return view("admin.datatables.view-status", [
                'status' => __('Paid'),
            ]);
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

        $dataTable->orderColumn('booking_source', static function ($query, $order) {
            $query->orderBy('booking_source', $order);
        });

        $dataTable->orderColumn('cancelled_date', static function ($query, $order) {
            $query->orderBy('cancelled_date', $order);
        });

        $dataTable->orderColumn('created', static function ($query, $order) {
            $query->orderBy('created_at', $order);
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

        $query->with('company');
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
            ->setTableId('report-booking-customer-list-datatable')
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
            Column::make('booking_source')->title(__('Booking Source'))
                ->addClass('text-center'),
            Column::make('company')->title(__('Company'))
                ->addClass('text-center'),
            Column::make('booking_user')->title(__('Booking User'))
                ->addClass('text-center'),
            Column::make('partner')->title(__('Partners Booking'))
                ->addClass('text-center'),
            Column::make('cancelled_date')->title(__('Charges Deadline'))
                ->addClass('text-center'),
            Column::make('created')->title(__('Created'))
                ->addClass('text-center'),
            Column::make('status')->title(__('Status'))
                ->addClass('text-center'),

            Column::make('total_price')->title(__('Total Price'))
                ->addClass('text-center')
                ->visible((\Auth::user())->hasRole('admin')),
            Column::make('currency')->title(__('Currency'))
                ->addClass('text-center')
                ->visible((\Auth::user())->hasRole('admin')),
            Column::make('commission')->title(__('Booking Commission'))
                ->addClass('text-center'),
            Column::make('currency_for_commission')->title(__('Currency'))
                ->addClass('text-center'),
            Column::make('vat')->title(__('Booking VAT'))
                ->addClass('text-center'),
            Column::make('currency_for_vat')->title(__('Currency'))
                ->addClass('text-center'),
            Column::make('pay_to_client')->title(__('Pay To Client'))
                ->addClass('text-center'),
            Column::make('currency_for_pay_to_client')->title(__('Currency'))
                ->addClass('text-center'),
            Column::make('sales_office_commission')->title(__('Sales Office Commissions'))
                ->addClass('text-center'),
            Column::make('currency_for_sales_office_commission')->title(__('Currency'))
                ->addClass('text-center'),

            Column::make('payment')->title(__('Payment'))
                ->width(200)
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
        return 'ReportBookingCustomer_' . date('YmdHis');
    }
}
