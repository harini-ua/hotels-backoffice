<?php

namespace App\DataTables;

use App\Enums\AllowedCurrency;
use App\Enums\BookingPlatform;
use App\Enums\BookingStatus;
use App\Enums\PaymentType;
use App\Models\Booking;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportBookingCustomerDataTable extends DataTable
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

        $dataTable->addColumn('hei_id', function (Booking $model) {
            return 'HEI'.$model->id;
        });

        $dataTable->addColumn('send', function (Booking $model) {
            return view('admin.datatables.send-action', [
                'model' => $model,
                'route' => route('send.booking.voucher_receipt', $model)
            ]);
        });

        $dataTable->addColumn('booking_source', function (Booking $model) {
            return BookingPlatform::getDescription($model->platform_type);
        });

        $dataTable->addColumn('checkin', function (Booking $model) {
            return Formatter::date($model->checkin);
        });

        $dataTable->addColumn('checkout', function (Booking $model) {
            return Formatter::date($model->checkout);
        });

        $dataTable->addColumn('booking_user', function (Booking $model) {
            return view('admin.datatables.view-link', [
                'model' => $model->bookingUser,
                'title' => $model->bookingUser->fullname,
            ]);
        });

        $dataTable->addColumn('company', function (Booking $model) {
            return view('admin.datatables.view-link', [
                'model' => $model->company,
                'title' => $model->company->company_name,
                'action' => 'edit'
            ]);
        });

        $dataTable->addColumn('partner', function (Booking $model) {
            return $model->partner_amount && $model->partner_currency_id
                ? __('YES') : __('NO');
        });

        $dataTable->addColumn('status', function (Booking $model) {
            return BookingStatus::getDescription($model->status);
        });

        $dataTable->addColumn('cancelled_date', function (Booking $model) {
            return Formatter::date($model->cancelled_date);
        });

        $dataTable->addColumn('created', function (Booking $model) {
            return Formatter::date($model->created_at);
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->addColumn('total_price', function (Booking $model) {
                $total = 0;
                if ($model->amount > 0) {
                    $isAllowedCurrency = in_array($model->selected_currency->code, AllowedCurrency::getValues(), true);
                    $total = $isAllowedCurrency ? $model->amount_conversion : $model->amount;

                    // If isset partner set max price
                    if ($model->company->partner) {
                        if ($model->company->mainOptions) {
                            $total = $model->company->mainOptions->max_price_filter ?? $total;
                        }
                    }

                    // If set partner amount
                    $total = $model->partner_amount ?? $total;
                    $total = round($total, 2);
                }

                return $total;
            });

            $dataTable->addColumn('currency', function (Booking $model) {
                $currency = $model->selected_currency->code;
                if ($model->amount > 0) {
                    $isAllowedCurrency = in_array($model->selected_currency->code, AllowedCurrency::getValues(), true);
                    $currency = $isAllowedCurrency ? $model->selected_currency->code : $model->original_currency->code;

                    // If isset partner set currency filter
                    if ($model->company->partner) {
                        if ($model->company->mainOptions) {
                            $currency = $model->company->mainOptions->currencyFilter->code;
                        }
                    }
                }

                // If set partner currency
                $currency = $model->partner_currency_id ?? $currency;

                return $currency;
            });
        }

        $dataTable->addColumn('amount_conversion', function (Booking $model) {
            return $model->amount_conversion;
        });

        $dataTable->addColumn('currency_for_amount_conversion', function (Booking $model) {
            return $model->original_currency->code;
        });

        $dataTable->addColumn('commission', function (Booking $model) {
            return $model->commission ;
        });

        $dataTable->addColumn('currency_for_commission', function (Booking $model) {
            return $model->original_currency->code;
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->addColumn('vat', function (Booking $model) {
                return $model->vat ? round($model->vat, 2) : 0;
            });

            $dataTable->addColumn('currency_for_vat', function (Booking $model) {
                return $model->original_currency->code;
            });
        }

        $dataTable->addColumn('pay_to_client', function (Booking $model) {
            return $model->pay_to_client ? round($model->pay_to_client, 2) : 0;
        });

        $dataTable->addColumn('currency_for_pay_to_client', function (Booking $model) {
            return $model->original_currency->code;
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->addColumn('sales_office_commission', function (Booking $model) {
                return $model->sales_office_commission ? round($model->sales_office_commission, 2) : 0;
            });

            $dataTable->addColumn('currency_for_sales_office_commission', function (Booking $model) {
                return $model->original_currency->code;
            });
        }

        $dataTable->addColumn('payment', function (Booking $model) {
            if ($model->amount > 0 && $model->payment_type == PaymentType::DISCOUNT) {
                return view("admin.datatables.actions", [
                    'actions' => ['payment'],
                    'model' => $model,
                    'route' => route('payment.booking', $model),
                ]);
            }

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
        $dataTable->orderColumn('booking_id', static function ($query, $order) {
            $query->orderBy('booking_reference', $order);
        });

        $dataTable->orderColumn('hei_id', static function ($query, $order) {
            $query->orderBy('id', $order);
        });

        $dataTable->orderColumn('booking_source', static function ($query, $order) {
            $query->orderBy('platform_type', $order);
        });

        $dataTable->orderColumn('checkin', static function ($query, $order) {
            $query->orderBy('checkin', $order);
        });

        $dataTable->orderColumn('checkout', static function ($query, $order) {
            $query->orderBy('checkout', $order);
        });

        $dataTable->orderColumn('partner', static function ($query, $order) {
            $query->orderByRaw('IF (`partner_currency_id`, 1, 0) '.$order);
        });

        $dataTable->orderColumn('status', static function ($query, $order) {
            $query->orderBy('status', $order);
        });

        $dataTable->orderColumn('cancelled_date', static function ($query, $order) {
            $query->orderBy('cancelled_date', $order);
        });

        $dataTable->orderColumn('created', static function ($query, $order) {
            $query->orderBy('created_at', $order);
        });

        $dataTable->orderColumn('amount_conversion', static function ($query, $order) {
            $query->orderBy('amount_conversion', $order);
        });

        $dataTable->orderColumn('commission', static function ($query, $order) {
            $query->orderBy('commission', $order);
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->orderColumn('vat', static function ($query, $order) {
                $query->orderBy('vat', $order);
            });
        }

        $dataTable->orderColumn('pay_to_client', static function ($query, $order) {
            $query->orderBy('pay_to_client', $order);
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->orderColumn('sales_office_commission', static function ($query, $order) {
                $query->orderBy('sales_office_commission', $order);
            });
        }
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

        $dataTable->filterColumn('hei_id', static function ($query, $keyword) {
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

        $query->with('company');
        $query->with('provider');
        $query->with('city');
        $query->with('country');
        $query->with('hotel');
        $query->with('selected_currency');
        $query->with('original_currency');
        $query->with('bookingUser.country');
        $query->with('discountCode.discount');

        if (!$this->request->has('quick_filter')) {
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
            Column::make('hei_id')->title(__('HEI ID'))
                ->addClass('text-center'),
            Column::make('send')->title(__('Re Send'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('booking_source')->title(__('Booking Source'))
                ->addClass('text-center'),
            Column::make('checkin')->title(__('Arrival Date'))
                ->addClass('text-center'),
            Column::make('checkout')->title(__('Departure Date'))
                ->addClass('text-center'),
            Column::make('booking_user')->title(__('Booking User'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('company')->title(__('Company'))
                ->addClass('text-center')
                ->orderable(false),
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
                ->orderable(false)
                ->visible((\Auth::user())->hasRole('admin')),
            Column::make('currency')->title(__('Currency'))
                ->addClass('text-center')
                ->orderable(false)
                ->visible((\Auth::user())->hasRole('admin')),
            Column::make('amount_conversion')->title(__('Original Cost'))
                ->addClass('text-center'),
            Column::make('currency_for_amount_conversion')->title(__('Currency'))
                ->addClass('text-center')
                ->orderable(false),
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
