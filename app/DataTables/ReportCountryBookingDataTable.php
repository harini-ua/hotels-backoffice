<?php

namespace App\DataTables;

use App\Enums\BookingDateType;
use App\Models\Booking;
use App\Models\Company;
use App\Models\Country;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportCountryBookingDataTable extends DataTable
{
    /**
     * @var array $period
     */
    public $period = [];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('name', function (Booking $model) {
            return $model->country_name;
        });

        $dataTable->addColumn('hotelbed', function (Booking $model) {
            return $model->hotelbed_count;
        });

        $dataTable->addColumn('jactravels', function (Booking $model) {
            return $model->jactravels_count;
        });

        $dataTable->addColumn('restel', function (Booking $model) {
            return $model->restel_count;
        });

        $dataTable->addColumn('gta', function (Booking $model) {
            return $model->gta_count;
        });

        $dataTable->addColumn('miki', function (Booking $model) {
            return $model->miki_count;
        });

        $dataTable->addColumn('travco', function (Booking $model) {
            return $model->travco_count;
        });

        $dataTable->addColumn('grn', function (Booking $model) {
            return $model->grn_count;
        });

        $dataTable->addColumn('total', function (Booking $model) {
            return $model->total_count;
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
        $dataTable->orderColumn('name', static function ($query, $order) {
            $query->orderBy('bookings.name', $order);
        });

        $dataTable->orderColumn('hotelbed', static function ($query, $order) {
            $query->orderBy('hotelbed_count', $order);
        });

        $dataTable->orderColumn('jactravels', static function ($query, $order) {
            $query->orderBy('jactravels_count', $order);
        });

        $dataTable->orderColumn('restel', static function ($query, $order) {
            $query->orderBy('restel_count', $order);
        });

        $dataTable->orderColumn('gta', static function ($query, $order) {
            $query->orderBy('gta_count', $order);
        });

        $dataTable->orderColumn('miki', static function ($query, $order) {
            $query->orderBy('miki_count', $order);
        });

        $dataTable->orderColumn('travco', static function ($query, $order) {
            $query->orderBy('travco_count', $order);
        });

        $dataTable->orderColumn('grn', static function ($query, $order) {
            $query->orderBy('grn_count', $order);
        });

        $dataTable->orderColumn('total', static function ($query, $order) {
            $query->orderBy('total_count', $order);
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
            $countryIds = Company::where('name', 'like', "%$keyword%")->pluck('id')->toArray();
            $query->whereIn('country_id', $countryIds);
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
        $query->with('country');

        $query->selectRaw('countries.id, countries.name AS country_name');

        $query->selectRaw('SUM(IF(provider_id = 1, 1, 0)) AS hotelbed_count');
        $query->selectRaw('SUM(IF(provider_id = 2, 1, 0)) AS jactravels_count');
        $query->selectRaw('SUM(IF(provider_id = 3, 1, 0)) AS restel_count');
        $query->selectRaw('SUM(IF(provider_id = 4, 1, 0)) AS gta_count');
        $query->selectRaw('SUM(IF(provider_id = 5, 1, 0)) AS miki_count');
        $query->selectRaw('SUM(IF(provider_id = 6, 1, 0)) AS travco_count');
        $query->selectRaw('SUM(IF(provider_id = 7, 1, 0)) AS grn_count');
        $query->selectRaw('SUM(provider_id) AS total_count');

        $query->join(Country::TABLE_NAME, 'countries.id', '=', 'bookings.country_id');

        if ($this->request->has('period')) {
            if ($this->request->has('company')) {
                $query->where('company_id', (int) $this->request->get('company'));
            }

            if ($this->request->has('country')) {
                $query->where('country_id', (int) $this->request->get('country'));
            }

            if ($this->request->has('city')) {
                $query->where('city_id', (int) $this->request->get('city'));
            }

            if ($this->request->has('hotel')) {
                $query->where('hotel_id', (int) $this->request->get('hotel'));
            }

            if ($this->request->has('status')) {
                $query->where('status', (int) $this->request->get('status'));
            }

            if ($this->request->has('platform_type')) {
                $query->where('platform_type', (int) $this->request->get('platform_type'));
            }

            if ($this->request->has('platform_version')) {
                $query->where('platform_version', $this->request->get('platform_version'));
            }

            $dates = explode(' - ', $this->request->get('period'));
            foreach ($dates as $key => $date) {
                $this->period[$key] = Carbon::createFromFormat('d/m/Y', $date);
            }

            if (BookingDateType::CONFIRMATION === (int) $this->request->get('date_type')) {
                $query->whereBetween('bookings.created_at', $this->period);
            } elseif (BookingDateType::CHECK === (int) $this->request->get('date_type')) {
                $query->whereDate('checkin', '<=', $this->period[0]);
                $query->whereDate('checkout', '>=', $this->period[0]);
            }
        } else {
            // Making the result empty on purpose
            $query->where('country_id', 0);
        }

        $query->groupBy('country_id');

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
            ->setTableId('country-booking-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrti')
            ->lengthMenu(config('admin.datatable.length_menu'))
            ->pageLength(-1)
            ->orderBy(8, 'desc')
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
            Column::make('name')->title(__('Country'))
                ->orderable(false)
                ->width(250)
                ->addClass('text-right'),
            Column::make('hotelbed')->title(__('HotelBed'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('jactravels')->title(__('JacTravels'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('restel')->title(__('Restel'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('gta')->title(__('GTA'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('miki')->title(__('Miki'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('travco')->title(__('Travco'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('grn')->title(__('GRN'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('total')->title(__('Total'))
                ->width(100)
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
        return 'ReportCountryBooking_' . date('YmdHis');
    }
}
