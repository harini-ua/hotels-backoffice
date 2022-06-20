<?php

namespace App\DataTables;

use App\Enums\AllowedCurrency;
use App\Enums\BookingDateType;
use App\Enums\BookingPlatform;
use App\Enums\BookingStatus;
use App\Enums\DiscountAmountType;
use App\Enums\PaymentType;
use App\Models\Booking;
use App\Services\Formatter;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportBookingCustomerAdvancedDataTable extends DataTable
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

        // Default Quick Search
        if (!$this->request->has('advanced_filter'))
        {
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
                        $isAllowedCurrency = in_array($model->currency->code, AllowedCurrency::getValues(), true);
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
                    $currency = $model->currency->code;
                    if ($model->amount > 0) {
                        $isAllowedCurrency = in_array($model->currency->code, AllowedCurrency::getValues(), true);
                        $currency = $isAllowedCurrency ? $model->currency->code : $model->original_currency->code;

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
                return $model->commission ?? 0;
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
        }
        // Advanced Search
        else {
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

            $dataTable->addColumn('total_price', function (Booking $model) {
                return '-';
            });

            $dataTable->addColumn('currency_for_total_price', function (Booking $model) {
                return $model->currency->code;
            });

            $dataTable->addColumn('extra_nights', function (Booking $model) {
                return $model->extra_nights ?? '-';
            });

            $dataTable->addColumn('discount', function (Booking $model) {
                $discount = '-';
                if ($model->discountCode) {
                    $voucher = $model->discountCode->discount;
                    $discount = $voucher->amount;

                    if (DiscountAmountType::Percent === (int) $voucher->amount_type) {
                        $discount .= '%';
                    }
                }

                return $discount;
            });

            $dataTable->addColumn('discount_type', function (Booking $model) {
                $type = '-';
                if ($model->discountCode) {
                    $voucher = $model->discountCode->discount;

                    switch ((int) $voucher->amount_type) {
                        case DiscountAmountType::Percent:
                            $type = '%';
                            break;
                        case DiscountAmountType::Fixed:
                            $type = $voucher->curency->code;
                            break;
                    }
                }

                return $type;
            });

            $dataTable->addColumn('discount_code', function (Booking $model) {
                return $model->discountCode->code ?? '-';
            });

            $dataTable->addColumn('partner', function (Booking $model) {
                return $model->partner_amount && $model->partner_currency_id
                    ? __('YES') : __('NO');
            });

            $dataTable->addColumn('status', function (Booking $model) {
                return BookingStatus::getDescription($model->status);
            });

            $dataTable->addColumn('commission', function (Booking $model) {
                return $model->commission ?? view('admin.datatables.view-icon', [
                    'icon' => 'feather icon-alert-octagon',
                    'title' => __('This booking is without any commission'),
                    'class' => 'danger'
                ]);
            });

            $dataTable->addColumn('cancel_till_date', function (Booking $model) {
                return Formatter::date($model->cancel_till_date);
            });

            $dataTable->addColumn('created', function (Booking $model) {
                return Formatter::date($model->created_at);
            });

            $dataTable->addColumn('provider', function (Booking $model) {
                if ((\Auth::user())->hasRole('admin')) {
                    return $model->provider->name ?? '-';
                }

                return __('Provider') .' '. $model->provider->id;
            });

            // TODO: Implement Advanced
        }

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
        // Advanced Search
        // TODO: Implement Advanced Order Columns
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
        $query->with('currency');
        $query->with('original_currency');
        $query->with('bookingUser.country');
        $query->with('discountCode.discount');

        if ($this->request->has('quick_filter')) {
            if ($this->request->has('check_in')) {
                $dates = explode(' - ', $this->request->get('check_in'));
                foreach ($dates as $key => $date) {
                    $this->datePeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
                }
            }

            $query->whereDate('checkin', '>=', $this->datePeriod[0]);
            $query->whereDate('checkout', '<=', $this->datePeriod[1]);
        }
        elseif ($this->request->has('advanced_filter')) {
            if ($this->request->has('period')) {
                $dates = explode(' - ', $this->request->get('period'));
                foreach ($dates as $key => $date) {
                    $this->datePeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
                }
            }

            switch ($this->request->has('date_type')) {
                case BookingDateType::CONFIRMATION:
                    $query->whereBetween('created_at', $this->datePeriod);
                    break;
                case BookingDateType::CHECK:
                default:
                    $query->whereDate('checkin', '>=', $this->datePeriod[0]);
                    $query->whereDate('checkout', '<=', $this->datePeriod[1]);
                    break;
            }
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
            Column::make('hei_id')->title(__('HEI ID'))
                ->addClass('text-center'),
            Column::make('send')->title(__('Re Send'))
                ->addClass('text-center'),
            Column::make('booking_source')->title(__('Booking Source'))
                ->addClass('text-center'),
            Column::make('checkin')->title(__('Start Date'))
                ->addClass('text-center'),
            Column::make('booking_user')->title(__('Booking User'))
                ->addClass('text-center'),
            Column::make('company')->title(__('Company'))
                ->addClass('text-center'),
            Column::make('total_price')->title(__('Total Price'))
                ->addClass('text-center'),
            Column::make('currency_for_total_price')->title(__('Currency'))
                ->addClass('text-center'),
            Column::make('extra_nights')->title(__('Extra Nights'))
                ->addClass('text-center'),
            Column::make('discount')->title(__('Discount'))
                ->addClass('text-center'),
            Column::make('discount_type')->title(__('Discount Type'))
                ->addClass('text-center'),
            Column::make('discount_code')->title(__('Discount Code'))
                ->addClass('text-center'),
            Column::make('partner')->title(__('Partners Booking'))
                ->addClass('text-center'),
            Column::make('status')->title(__('Status'))
                ->addClass('text-center'),
            Column::make('cancel_till_date')->title(__('Charges Deadline'))
                ->addClass('text-center'),
            Column::make('created')->title(__('Requested Date'))
                ->addClass('text-center'),
            Column::make('provider')->title(__('Provider'))
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
        return 'ReportBookingCustomer_' . date('YmdHis');
    }
}
