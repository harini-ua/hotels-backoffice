<?php

namespace App\DataTables;

use App\Models\Language;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LanguagesDataTable extends DataTable
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

        $dataTable->addColumn('name', function (Language $model) {
            return $model->name;
        });

        $dataTable->addColumn('translation', function (Language $model) {
            return $model->translation;
        });

        $dataTable->addColumn('code', function (Language $model) {
            return $model->code;
        });

        $dataTable->addColumn('icon', function (Language $model) {
            return view("admin.datatables.view-flag", ['code' => $model->code]);
        });

        $dataTable->addColumn('active', function (Language $model) {
            return view("admin.pages.languages.partials._active-switch", compact('model'));
        });

        $dataTable->addColumn('action', function (Language $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'settings.languages'
            ]);
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            //..
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

        $dataTable->orderColumn('translation', static function ($query, $order) {
            $query->orderBy('translation', $order);
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

        $dataTable->filterColumn('translation', static function ($query, $keyword) {
            $query->where('translation', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('code', static function ($query, $keyword) {
            $query->where('code', 'like', "%$keyword%");
        });
    }

    /**s
     * Get query source of dataTable.
     *
     * @param \App\Models\Language $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Language $model)
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
            ->setTableId('languages-list-datatable')
            ->addTableClass('table table-striped table-bordered dataTable no-footer dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0)
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
            Column::make('name')->title(__('Language')),
            Column::make('translation')->title(__('Translation')),
            Column::make('code')->title(__('Code'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('icon')->title(__('Icon'))
                ->width(100)
                ->addClass('text-center'),
            Column::make('active')->title(__('Active'))
                ->width(100)
                ->addClass('text-center'),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(150)
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
        return 'Languages_' . date('YmdHis');
    }
}
