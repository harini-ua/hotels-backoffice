<?php

namespace App\DataTables;

use App\Models\Country;
use Carbon\Carbon;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HotelsNewestDataTable extends DataTable
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

        $dataTable->addColumn('new_hotels', function (Country $model) {
            return $model->new_hotels ?? '-';
        });

        $dataTable->addColumn('auto_binded_hotels', function (Country $model) {
            return $model->auto_binded_hotels ?? '-';
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
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

        $dataTable->orderColumn('new_hotels', static function ($query, $order) {
            // TODO: Need Implement
        });

        $dataTable->orderColumn('auto_binded_hotels', static function ($query, $order) {
            // TODO: Need Implement
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
            ->setTableId('hotels-newest-datatable')
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
                Button::make('postExcel'),
                Button::make('print')
            )
            ->drawCallback("function () {
                var api = this.api();

                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'number' ? i : 0;
                };

                total = api.column(1).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(1).footer()).html('Total: '+ total);

                total = api.column(2).data().reduce(function(a, b) { return intVal(a) + intVal(b); }, 0);
                $(api.column(2).footer()).html('Total: '+ total);
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
            Column::make('name')->title(__('Country'))
                ->width(250)
                ->addClass('text-right'),
            Column::make('new_hotels')->title(__('New Hotels'))
                ->width(100)
                ->addClass('text-left'),
            Column::make('auto_binded_hotels')->title(__('Auto Binded Hotels'))
                ->width(100)
                ->addClass('text-left'),
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
