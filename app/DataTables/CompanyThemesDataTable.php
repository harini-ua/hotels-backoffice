<?php

namespace App\DataTables;

use App\Models\CompanyTheme;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CompanyThemesDataTable extends DataTable
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

        $dataTable->addColumn('theme_name', function (CompanyTheme $model) {
            return !$model->default ? $model->theme_name : $model->theme_name.' ('.__('Default').')';
        });

        $dataTable->addColumn('theme_color', function (CompanyTheme $model) {
            return view('admin.datatables.view-color', [
                'color' => $model->theme_color,
            ]);
        });

        $dataTable->addColumn('action', function (CompanyTheme $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'companies.themes'
            ]);
        });

        $this->setOrderColumns($dataTable);

        return $dataTable;
    }

    /**
     * Set order columns
     *
     * @param $dataTable
     */
    protected function setOrderColumns($dataTable)
    {
        $dataTable->orderColumn('theme_name', static function ($query, $order) {
            $query->orderBy('theme_name', $order);
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CompanyTheme $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CompanyTheme $model)
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
            ->setTableId('companies-themes-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(0, 'asc')
            ->dom('rtip')
            ->orderBy(1)
            ->buttons(
                Button::make('excel'),
                Button::make('print'),
                Button::make('reload')
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
            Column::make('id')->title(__('ID')),
            Column::make('theme_name')->title(__('Theme Name')),
            Column::make('theme_color')->title(__('Base Color'))->orderable(false),
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
        return 'CompanyThemes_' . date('YmdHis');
    }
}
