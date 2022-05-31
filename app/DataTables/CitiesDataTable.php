<?php

namespace App\DataTables;

use App\Models\City;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CitiesDataTable extends DataTable
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

        $dataTable->addColumn('name', function (City $model) {
            return $model->name;
        });

        $dataTable->addColumn('country', function (City $model) {
            return $model->country->name;
        });

        $dataTable->addColumn('hotels_count', function (City $model) {
            return $model->hotels_count;
        });

        $dataTable->addColumn('commission', function (City $model) {
            return $model->commission;
        });

        $dataTable->addColumn('active', function (City $model) {
            return view("admin.pages.cities.partials._active-switch", compact('model'));
        });

        $dataTable->addColumn('action', function (City $model) {
            return view("admin.datatables.actions", ['actions' => ['edit'], 'model' => $model]);
        });

        $dataTable->rawColumns(['active']);

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('country')) {
                $query->where('country_id', $this->request->get('country'));
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

        $dataTable->orderColumn('hotels_count', static function ($query, $order) {
            $query->orderBy('hotels_count', $order);
        });

        $dataTable->orderColumn('commission', static function ($query, $order) {
            $query->orderBy('commission', $order);
        });

        $dataTable->orderColumn('active', static function ($query, $order) {
            $query->orderBy('active', $order);
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
     * @param \App\Models\City $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(City $model)
    {
        return $model->newQuery()
            ->with(['country']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('cities-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->responsive(true)
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
            Column::make('id')->title(__('ID'))
                ->width(70),
            Column::make('name')->title(__('City')),
            Column::make('country')->title(__('Country'))
                ->orderable(false),
            Column::make('hotels_count')->title(__('Hotels Count'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('commission')->title(__('Commission'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('active')
                ->orderable('false')
                ->width(100)
                ->addClass('text-center'),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
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
        return 'Cities_' . date('YmdHis');
    }
}
