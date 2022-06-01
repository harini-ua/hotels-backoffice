<?php

namespace App\DataTables;

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

        $dataTable->addColumn('name', function (Country $model) {
            return $model->name;
        });

        $dataTable->addColumn('hotelbed', function (Country $model) {
            return '-';
        });

        $dataTable->addColumn('jactravels', function (Country $model) {
            return '-';
        });

        $dataTable->addColumn('restel', function (Country $model) {
            return '-';
        });

        $dataTable->addColumn('gta', function (Country $model) {
            return '-';
        });

        $dataTable->addColumn('miki', function (Country $model) {
            return '-';
        });

        $dataTable->addColumn('travco', function (Country $model) {
            return '-';
        });

        $dataTable->addColumn('grn', function (Country $model) {
            return '-';
        });

        $dataTable->addColumn('total', function (Country $model) {
            return '-';
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if (!$this->request->has('company')) {
                // TODO: Need implement
            }
            if (!$this->request->has('country')) {
                // TODO: Need implement
            }
            if (!$this->request->has('city')) {
                // TODO: Need implement
            }
            if (!$this->request->has('period')) {
                // Making the result empty on purpose
                $query->where('countries.id', 0);
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
        $dataTable->orderColumn('name', static function ($query, $order) {
            $query->orderBy('name', $order);
        });

        $dataTable->orderColumn('hotelbed', static function ($query, $order) {
            // TODO: Need implement
        });

        $dataTable->orderColumn('jactravels', static function ($query, $order) {
            // TODO: Need implement
        });

        $dataTable->orderColumn('restel', static function ($query, $order) {
            // TODO: Need implement
        });

        $dataTable->orderColumn('gta', static function ($query, $order) {
            // TODO: Need implement
        });

        $dataTable->orderColumn('miki', static function ($query, $order) {
            // TODO: Need implement
        });

        $dataTable->orderColumn('travco', static function ($query, $order) {
            // TODO: Need implement
        });

        $dataTable->orderColumn('grn', static function ($query, $order) {
            // TODO: Need implement
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
            $query->where('name', 'like', "%$keyword%");
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Country $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Country $model)
    {
        if ($this->request->has('period')) {
            $dates = explode(' - ', $this->request->get('period'));
            foreach ($dates as $key => $date) {
                $this->period[$key] = Carbon::createFromFormat('d/m/Y', $date);
            }
        }

        $query = $model->newQuery();

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
            ->setTableId('country-booking-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrti')
            ->pageLength(Country::all()->count())
            ->orderBy(1)
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
            Column::make('name')->title(__('Country'))
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
        return 'HotelsNewest_' . date('YmdHis');
    }
}
