<?php

namespace App\DataTables;

use App\Enums\BookingStatus;
use App\Enums\PaymentType;
use App\Models\Booking;
use App\Models\CompanySaleOfficeCommission;
use App\Services\Formatter;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportInvoiceAdvancedDataTable extends DataTable
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
            return $model->original_currency->code;
        });

        $dataTable->addColumn('fixed_amount', function (Booking $model) {
            $bookingCommission = $model->company->bookingCommission;

            // Get company booking standard commission
            $standardCommission = ($bookingCommission->standard_commission / 100);
            return round($standardCommission * $model->sales_office_commission, 2);
        });

        if ((\Auth::user())->hasRole('admin')) {
            $dataTable->addColumn('commission', function (Booking $model) {
                return $model->commission;
            });
        }

        $dataTable->addColumn('company_commission', function (Booking $model) {
            $payBackClient = 0;
            $bookingCommission = $model->company->bookingCommission;
            if ($bookingCommission) {
                $payBackClient = $model->commission * ($bookingCommission->pay_to_client / 100);
            }

            return $payBackClient;
        });

        $dataTable->addColumn('sub_company_commission', function (Booking $model) {
            return round($model->sub_company_commission, 2);
        });

        $dataTable->addColumn('vat', function (Booking $model) {
            $vat = $model->company->vats()
                ->where('country_id', $model->company->country_id)
                ->first();

            $result = 0;
            if ($vat) {
                $bookingCommission = $model->company->bookingCommission;
                // If set commission pay to client
                if ($bookingCommission->pay_to_client) {
                    $payBackClient = $model->commission * ($bookingCommission->pay_to_client / 100);
                    $hqDistributor = $model->commission - $payBackClient;
                } else {
                    $hqDistributor = $model->commission;
                }

                $result = $hqDistributor * ($vat->percentage / 100);
            }

            return $result;
        });

        if ((\Auth::user())->hasRole('admin')) {
            $salesOfficeLevel1 = DB::table(CompanySaleOfficeCommission::TABLE_NAME)
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
                    return 0; // TODO: Need Implement
                });
            }

            $salesOfficeLevel2 = DB::table(CompanySaleOfficeCommission::TABLE_NAME)
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
                    return 0; // TODO: Need Implement
                });
            }
        }

        $dataTable->addColumn('total_currency', function (Booking $model) {
            return $model->original_currency->code;
        });

        $dataTable->addColumn('final_amount', function (Booking $model) {
            return $model->final_amount;
        });

        $dataTable->addColumn('distributor_commission', function (Booking $model) {
            return 0; // TODO: Need Implement
        });

        $dataTable->addColumn('amount_invoiced', function (Booking $model) {
            return 0; // TODO: Need Implement
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
            if ($this->request->has('order_id')) {
                $query->where('booking_reference', $this->request->get('order_id'));
            }
            if ($this->request->has('booking_id')) {
                $query->where('id', $this->request->get('booking_id'));
            }
            if ($this->request->has('voucher_date')) {
                $dates = explode(' - ', $this->request->get('voucher_date'));
                foreach ($dates as $key => $date) {
                    $this->datePeriod[$key] = Carbon::createFromFormat('d/m/Y', $date);
                }

                $query->whereBetween('created_at', $this->datePeriod);
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

        $dataTable->orderColumn('commission', static function ($query, $order) {
            $query->orderBy('commission', $order);
        });

        $dataTable->orderColumn('final_amount', static function ($query, $order) {
            $query->orderBy('final_amount', $order);
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
        $query->with('company.bookingCommission');
        $query->with('hotel');
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
            ->setTableId('report-invoice-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lrtip')
            ->pageLength(50)
            ->orderBy(2, 'desc')
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
        $columns = [
            Column::make('booking_id')->title(__('Booking ID'))
                ->width(150)
                ->orderable(false),
            Column::make('id')->title(__('ID'))->addClass('text-center'),
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
            Column::make('customer_name')->title(__('Client Name'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('client_country')->title(__('Client Country'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('total_amount')->title(__('Total Amount Charged'))
                ->addClass('text-center'),
            Column::make('currency_for_total_amount')->title(__('Currency'))
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('fixed_amount')->title(__('Fixed Amount'))
                ->addClass('text-center'),
            Column::make('commission')->title(__('Total Comm.'))
                ->addClass('text-center')
                ->visible((\Auth::user())->hasRole('admin')),
            Column::make('company_commission')->title(__('Comm. Company')),
            Column::make('sub_company_commission')->title(__('Comm. Sub-Company')),
            Column::make('vat')->title(__('VAT')),
            Column::make('total_currency')->title(__('Currency'))
                ->orderable(false)
                ->addClass('text-center'),
        ];

        $salesOfficeLevel1 = DB::table(CompanySaleOfficeCommission::TABLE_NAME)
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

        $salesOfficeLevel2 = DB::table(CompanySaleOfficeCommission::TABLE_NAME)
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

        $columns[] = Column::make('final_amount')->title(__('Final Amount'))
            ->addClass('text-center');
        $columns[] = Column::make('distributor_commission')->title(__('Distributor Commission'))
            ->orderable(false)
            ->addClass('text-center');
        $columns[] = Column::make('amount_invoiced')->title(__('Amount Invoiced'))
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
        return 'ReportInvoiceAdvanced_' . date('YmdHis');
    }
}
