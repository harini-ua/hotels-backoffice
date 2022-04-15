<?php

namespace App\DataTables;

use App\Models\Partner;
use App\Services\Formatter;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PartnersDataTable extends DataTable
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

        $dataTable->addColumn('name', function(Partner $model) {
            return $model->name ?? '-';
        });

        $dataTable->addColumn('description', function(Partner $model) {
            return $model->description ?? '-';
        });

        $dataTable->addColumn('internal', function(Partner $model) {
            if ($model->internal == 1) {
                return __('Internal');
            }

            return __('External');
        });

        $dataTable->addColumn('created_at', function(Partner $model) {
            return Formatter::date($model->created_at);
        });

        $dataTable->addColumn('action', function (Partner $model) {
            return view("admin.datatables.actions", ['actions' => ['edit', 'delete'], 'model' => $model]);
        });

        $this->setFilterColumns($dataTable);

        $dataTable->filter(function($query) {
            if ($this->request->has('internal')) {
                $query->where('internal', $this->request->get('internal'));
            }
        }, true);

        return $dataTable;
    }

    /**
     * Set filter columns
     *
     * @param $dataTable
     */
    protected function setFilterColumns($dataTable)
    {
        $dataTable->filterColumn('name', static function($query, $keyword) {
            $query->where('name', 'like', "%$keyword%");
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Partner $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Partner $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('partners-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(1)
            ->language([
                'search' => '',
                'searchPlaceholder' => __('Search')
            ])
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
            Column::make('id')->title(__('ID')),
            Column::make('name')->title(__('Partner Name')),
            Column::make('description')->title(__('Description')),
            Column::make('internal')->title(__('API Type')),
            Column::make('created_at')->title(__('Date Create')),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(200)
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
        return 'Partners_' . date('YmdHis');
    }
}
