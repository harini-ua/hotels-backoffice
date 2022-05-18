<?php

namespace App\DataTables;

use App\Models\Country;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CountriesDataTable extends DataTable
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

        $dataTable->addColumn('code', function (Country $model) {
            return $model->code;
        });

        $dataTable->addColumn('currency', function (Country $model) {
            return $model->currency->code;
        });

        $dataTable->addColumn('language', function (Country $model) {
            return $model->language->name;
        });

        $dataTable->addColumn('active', function (Country $model) {
            return view("admin.pages.countries.partials._active-switch", compact('model'));
        });

        $dataTable->addColumn('action', function (Country $model) {
            return view("admin.datatables.actions", ['actions' => ['edit'], 'model' => $model]);
        });

        $dataTable->rawColumns(['active']);

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('currency')) {
                $query->where('currency_id', $this->request->get('currency'));
            }
            if ($this->request->has('language')) {
                $query->where('language_id', $this->request->get('language'));
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

        $dataTable->orderColumn('code', static function ($query, $order) {
            $query->orderBy('code', $order);
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
     * @param \App\Models\Country $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Country $model)
    {
        return $model->newQuery()
            ->with(['currency', 'language']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('countries-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->language([
                'search' => '',
                'searchPlaceholder' => __('Search')
            ])
            ->buttons(
                Button::make('postExcel'),
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
            Column::make('name')->title(__('Country')),
            Column::make('code')->title(__('Code'))
                ->width(70)
                ->addClass('text-center'),
            Column::make('currency')->title(__('Currency'))
                ->orderable(false),
            Column::make('language')->title(__('Language'))
                ->orderable(false),
            Column::make('active')
                ->orderable('false')
                ->width(70)
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
        return 'Counties_' . date('YmdHis');
    }
}
