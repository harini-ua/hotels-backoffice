<?php

namespace App\DataTables;

use App\Enums\AllowedCurrency;
use App\Enums\BookingStatus;
use App\Enums\PaymentType;
use App\Models\Booking;
use App\Models\CompanySaleOfficeCommission;
use App\Services\Converter;
use App\Services\Formatter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportBookingCommissionDataTable extends DataTable
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

        $dataTable->addColumn('customer_name', function (Booking $model) {
            return $model->customer_name;
        });

        $dataTable->addColumn('client_country', function (Booking $model) {
            return $model->bookingUser->country->name;
        });

        $dataTable->addColumn('total_amount', function (Booking $model) {
            return $model->partner_amount ?? $model->amount;
        });

        $dataTable->addColumn('currency_for_total_amount', function (Booking $model) {
            $currency = $model->selected_currency->code;
            if ($model->amount > 0) {
                $isAllowedCurrency = in_array($model->selected_currency->code, AllowedCurrency::getValues(), true);
                $currency = $isAllowedCurrency ? $model->selected_currency->code : $model->original_currency->code;
            }

            // If set partner currency
            return $model->partner_currency_id ?? $currency;
        });

        $dataTable->addColumn('partner', function (Booking $model) {
            return $model->partner_amount && $model->partner_currency_id
                ? __('YES') : __('NO');
        });

        $dataTable->addColumn('fixed_amount', function (Booking $model) {
            $fixed = 0;
            $bookingCommission = $model->company->bookingCommission;
            // If isset company booking commission
            if ($bookingCommission) {
                $isAllowedCurrency = in_array($model->selected_currency->code, AllowedCurrency::getValues(), true);
                // Convert price by original currency
                $providerPrice = Converter::price($model->amount, $model->original_currency->code, 'EUR');
                if ($isAllowedCurrency) {
                    // Convert price by user selected currency
                    $providerPrice = Converter::price($model->amount, 'EUR', $model->selected_currency->code);
                }

                // Get company booking standard commission
                $standardCommission = ($bookingCommission->standard_commission / 100);
                $fixed = round($providerPrice * $standardCommission, 2);
            }

            return $fixed;
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->addColumn('commission', function (Booking $model) {
                return $model->commission;
            });
        }

        $dataTable->addColumn('company_commission', function (Booking $model) {
            return round($model->pay_to_client, 2);
        });

        $dataTable->addColumn('sub_company_commission', function (Booking $model) {
            return round($model->sub_company_commission ?? 0, 2);
        });

        $dataTable->addColumn('vat', function (Booking $model) {
            return round($model->vat, 2);
        });

        if ((\Auth::user())->hasRole('admin')) {
            $salesOfficeLevel1 = DB::table('company_sale_office_commission')
                ->select(DB::raw('COUNT(*) AS count'))
                ->where('level', 1)
                ->groupBy('company_id')
                ->get();

            $maxLevel1 = 1;
            if ($salesOfficeLevel1) {
                $maxLevel1 = $salesOfficeLevel1->max('count') ?? 1;
            }

            for ($i=1; $i <= $maxLevel1; $i++) {
                $dataTable->addColumn('commission_level_1_'.$i, function (Booking $model) {
                    return '?'; // TODO: Need Implement
                });
            }

            $salesOfficeLevel2 = DB::table('company_sale_office_commission')
                ->select(DB::raw('COUNT(*) AS count'))
                ->where('level', 2)
                ->groupBy('company_id')
                ->get();

            $maxLevel2 = 1;
            if ($salesOfficeLevel2) {
                $maxLevel2 = $salesOfficeLevel2->max('count') ?? 1;
            }

            for ($i=1; $i <= $maxLevel2; $i++) {
                $dataTable->addColumn('commission_level_2_'.$i, function (Booking $model) {
                    return '?'; // TODO: Need Implement
                });
            }
        }

        $dataTable->addColumn('total_currency', function (Booking $model) {
            $currency = $model->selected_currency->code;
            if ($model->amount > 0) {
                $isAllowedCurrency = in_array($model->selected_currency->code, AllowedCurrency::getValues(), true);
                $currency = $isAllowedCurrency ? $model->selected_currency->code : $model->original_currency->code;
            }

            return $currency;
        });

        $dataTable->addColumn('status', function (Booking $model) {
            return BookingStatus::getDescription($model->status);
        });

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
        $dataTable->orderColumn('hei_id', static function ($query, $order) {
            $query->orderBy('id', $order);
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

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->orderColumn('commission', static function ($query, $order) {
                $query->orderBy('commission', $order);
            });
        }

        $dataTable->orderColumn('company_commission', static function ($query, $order) {
            $query->orderBy('company_commission', $order);
        });

        $dataTable->orderColumn('sub_company_commission', static function ($query, $order) {
            $query->orderBy('sub_company_commission', $order);
        });

        $dataTable->orderColumn('vat', static function ($query, $order) {
            $query->orderBy('vat', $order);
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

        $query->with('provider');
        $query->with('city');
        $query->with('country');
        $query->with('company.bookingCommission');
        $query->with('hotel');
        $query->with('bookingUser.country');
        $query->with('discountCode');

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
            ->setTableId('report-booking-commission-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtip')
            ->pageLength(50)
            ->orderBy(2, 'desc')
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
        $columns = [];

        $columns[] = Column::make('booking_id')->title(__('Booking ID'))
            ->width(150)
            ->orderable(false);
        $columns[] = Column::make('hei_id')->title(__('HEI ID'))
            ->addClass('text-center');
        $columns[] = Column::make('checkin')->title(__('Arrival Date'))
            ->addClass('text-center');
        $columns[] = Column::make('checkout')->title(__('Departure Date'))
            ->addClass('text-center');
        $columns[] = Column::make('city')->title(__('City'))
            ->orderable(false)
            ->addClass('text-center');
        $columns[] = Column::make('country')->title(__('Country'))
            ->orderable(false)
            ->addClass('text-center');
        $columns[] = Column::make('hotel')->title(__('Hotel'))
            ->orderable(false)
            ->addClass('text-center');
        $columns[] =  Column::make('customer_name')->title(__('Client Name'))
            ->orderable(false)
            ->addClass('text-center');
        $columns[] = Column::make('client_country')->title(__('Client Country'))
            ->orderable(false)
            ->addClass('text-center');
        $columns[] = Column::make('total_amount')->title(__('Total Amount Charged'))
            ->addClass('text-center');
        $columns[] = Column::make('currency_for_total_amount')->title(__('Currency'))
            ->orderable(false)
            ->addClass('text-center');
        $columns[] = Column::make('partner')->title(__('Partners Booking'))
            ->addClass('text-center')
            ->orderable(false);
        $columns[] = Column::make('fixed_amount')->title(__('Fixed Amount'))
            ->addClass('text-center');
        $columns[] = Column::make('commission')->title(__('Total Comm.'))
            ->addClass('text-center')
            ->visible((\Auth::user())->hasRole('admin'));
        $columns[] = Column::make('company_commission')->title(__('Comm. Company'));
        $columns[] = Column::make('sub_company_commission')->title(__('Comm. Sub-Company'));
        $columns[] = Column::make('vat')->title(__('VAT'));

        $salesOfficeLevel1 = DB::table('company_sale_office_commission')
            ->select(DB::raw('COUNT(*) AS count'))
            ->where('level', 1)
            ->groupBy('company_id')
            ->get();

        $maxLevel1 = 1;
        if ($salesOfficeLevel1) {
            $maxLevel1 = $salesOfficeLevel1->max('count') ?? 1;
        }

        for ($i=1; $i <= $maxLevel1; $i++) {
            $columns[] = Column::make('commission_level_1_'.$i)
                ->title(__('Comm. Level 1-'.$i))
                ->orderable(false)
                ->visible((\Auth::user())->hasRole('admin'));
        }

        $salesOfficeLevel2 = DB::table('company_sale_office_commission')
            ->select(DB::raw('COUNT(*) AS count'))
            ->where('level', 2)
            ->groupBy('company_id')
            ->get();

        $maxLevel2 = 1;
        if ($salesOfficeLevel2) {
            $maxLevel2 = $salesOfficeLevel2->max('count') ?? 1;
        }

        for ($i=1; $i <= $maxLevel2; $i++) {
            $columns[] = Column::make('commission_level_2_'.$i)
                ->title(__('Comm. Level 2-'.$i))
                ->orderable(false)
                ->visible((\Auth::user())->hasRole('admin'));
        }

        $columns[] = Column::make('total_currency')->title(__('Currency'))
            ->orderable(false)
            ->addClass('text-center');
        $columns[] = Column::make('status')->title(__('Status'))
            ->addClass('text-center');
        $columns[] = Column::make('payment')->title(__('Payment'))
            ->addClass('text-center');

        return $columns;
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
