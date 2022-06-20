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

            $dataTable->addColumn('partner_giftcard_id', function (Booking $model) {
                return $model->partner_giftcard_id ?? '-';
            });

            $dataTable->addColumn('provider_price', function (Booking $model) {
                return '-'; // TODO: Need Implement
            });

            $dataTable->addColumn('bank_cost', function (Booking $model) {
                return '-'; // TODO: Need Implement
            });

            $dataTable->addColumn('difference_amount', function (Booking $model) {
                return '-'; // TODO: Need Implement
            });

            $dataTable->addColumn('total_price', function (Booking $model) {
                return '-'; // TODO: Need Implement
            });

            $dataTable->addColumn('currency_for_total_price', function (Booking $model) {
                return $model->selected_currency->code;
            });

            $dataTable->addColumn('extra_nights', function (Booking $model) {
                return $model->extra_nights;
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
                return $model->commission > 0 ? $model->commission :
                    view('admin.datatables.view-icon', [
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
        }

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('order_id')) {
                $query->where('booking_reference', $this->request->get('order_id'));
            }
            if ($this->request->has('booking_id')) {
                $query->where('id', $this->request->get('booking_id'));
            }
            if ($this->request->has('status')) {
                $query->where('status', $this->request->get('status'));
            }
            if ($this->request->has('period')) {
                $dates = explode(' - ', $this->request->get('period'));
                foreach ($dates as $key => $date) {
                    $this->datePeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
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

        $dataTable->orderColumn('extra_nights', static function ($query, $order) {
            $query->orderBy('extra_nights', $order);
        });

        $dataTable->orderColumn('discount_code', static function ($query, $order) {
            $query->orderBy('discount_voucher_code_id', $order);
        });

        $dataTable->orderColumn('partner', static function ($query, $order) {
            $query->orderByRaw('IF (`partner_currency_id`, 1, 0) '.$order);
        });

        $dataTable->orderColumn('status', static function ($query, $order) {
            $query->orderBy('status', $order);
        });

        $dataTable->orderColumn('commission', static function ($query, $order) {
            $query->orderBy('commission', $order);
        });

        $dataTable->orderColumn('cancel_till_date', static function ($query, $order) {
            $query->orderBy('cancellation_date', $order);
        });

        $dataTable->orderColumn('created', static function ($query, $order) {
            $query->orderBy('created_at', $order);
        });

        $dataTable->orderColumn('provider', static function ($query, $order) {
            $query->orderBy('provider_id', $order);
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
            Column::make('checkin')->title(__('Start Date'))
                ->addClass('text-center'),
            Column::make('booking_user')->title(__('Booking User'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('company')->title(__('Company'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('partner_giftcard_id')->title(__('Partner GifCard ID'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('provider_price')->title(__('Provider Price'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('bank_cost')->title(__('Bank Cost + Commission'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('difference_amount')->title(__('Difference Amount'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('total_price')->title(__('Total Price'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('currency_for_total_price')->title(__('Currency'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('extra_nights')->title(__('Extra Nights'))
                ->addClass('text-center'),
            Column::make('discount')->title(__('Discount'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('discount_type')->title(__('Discount Type'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('discount_code')->title(__('Discount Code'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('partner')->title(__('Partners Booking'))
                ->addClass('text-center')
                ->orderable(false),
            Column::make('status')->title(__('Status'))
                ->addClass('text-center'),
            Column::make('commission')->title(__('Commission'))
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
