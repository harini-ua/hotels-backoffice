<?php

namespace App\DataTables;

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReportHotelsSummaryDataTable extends DataTable
{
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

        $dataTable->addColumn('unique_hotels', function (Country $model) {
            return $model->unique_hotels ?? '-';
        });

        $dataTable->addColumn('fix_commission_hotels', function (Country $model) {
            return $model->fix_commission_hotels ?? '-';
        });

        $dataTable->addColumn('average_fix_commission', function (Country $model) {
            return $model->average_fix_commission ? round($model->average_fix_commission,2) : '-';
        });

        $dataTable->addColumn('average_commission', function (Country $model) {
            return $model->average_commission ? round($model->average_commission,2) : '-';
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
            $query->orderBy('name', $order);
        });

        $dataTable->orderColumn('unique_hotels', static function ($query, $order) {
            $query->orderBy('unique_hotels', $order);
        });

        $dataTable->orderColumn('fix_commission_hotels', static function ($query, $order) {
            $query->orderBy('fix_commission_hotels', $order);
        });

        $dataTable->orderColumn('average_fix_commission', static function ($query, $order) {
            $query->orderBy('average_fix_commission', $order);
        });

        $dataTable->orderColumn('average_commission', static function ($query, $order) {
            $query->orderBy('average_commission', $order);
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
        $query = $model->newQuery();
        $query->select([ 'country.id', 'country.name', 'country.commission', 'country.active']);
        $query->selectRaw('COUNT(country.id) AS country_count');
        $query->selectRaw('unique_hotels.value AS unique_hotels');
        $query->selectRaw('(unique_hotels.value - commission_hotels.count) AS empty_hotels');
        $query->selectRaw('commission_hotels.count AS fix_commission_hotels');
        $query->selectRaw('commission_hotels.avg AS average_fix_commission');
        $query->selectRaw(
        '(
            ( commission_hotels.sum + (unique_hotels.value - commission_hotels.count) * country.commission)
            /
            commission_hotels.count + (unique_hotels.value - commission_hotels.count)
        ) AS average_commission');

        $query->fromRaw('countries AS country');
        $query->where('country.active', 1);

        // Unique Hotels
        $unique_hotels = DB::table(Hotel::TABLE_NAME)
            ->select([
                'cities.country_id AS country_id',
                DB::raw('COUNT(hotels.id) AS value'),
            ])
            ->join(City::TABLE_NAME, 'cities.id', '=', 'hotels.city_id')
            ->groupBy('country_id');

        $query->leftJoinSub($unique_hotels, 'unique_hotels', static function($join) {
            $join->on('country.id', '=', 'unique_hotels.country_id');
        });

        $commission_hotels = DB::table(Hotel::TABLE_NAME)
            ->select([
                'cities.country_id AS country_id',
                DB::raw('COUNT(hotels.id) AS count'),
                DB::raw('AVG(hotels.commission) AS avg'),
                DB::raw('SUM(hotels.commission) AS sum'),
            ])
            ->join(City::TABLE_NAME, 'cities.id', '=', 'hotels.city_id')
            ->where('hotels.commission', '>', 0)
            ->groupBy('country_id');

        $query->leftJoinSub($commission_hotels, 'commission_hotels', static function($join) {
            $join->on('country.id', '=', 'commission_hotels.country_id');
        });

        $query->groupBy('country.id');

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
            ->setTableId('hotels-summary-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrti')
            ->pageLength(Country::all()->count())
            ->orderBy(1)
            ->lengthMenu(config('admin.datatable.length_menu'))
            ->pageLength(config('admin.datatable.page_length'))
            ->buttons(
                Button::make('excel'),
                Button::make('print')
            )
            ->drawCallback("function () {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'number' ? i : 0;
                };

                total = api.column(1).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(1).footer()).html('('+ total +')');

                total = api.column(2).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(2).footer()).html('('+ total +')');

                total = api.column(3).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(3).footer()).html('('+ total +')');

                total = api.column(4).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(4).footer()).html('('+ total +')');
            }")
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
            Column::make('name')->title(__('Country')),
            Column::make('unique_hotels')->title(__('Unique Hotels'))
                ->width(100)->addClass('text-center'),
            Column::make('fix_commission_hotels')->title(__('With Fixed Commission'))
                ->width(100)->addClass('text-center'),
            Column::make('average_fix_commission')->title(__('Average Fixed Commission'))
                ->width(100)->addClass('text-center'),
            Column::make('average_commission')->title(__('Average Commission'))
                ->width(100)->addClass('text-center'),

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'HotelsSummary_' . date('YmdHis');
    }
}
