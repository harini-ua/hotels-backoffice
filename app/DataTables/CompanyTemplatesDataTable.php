<?php

namespace App\DataTables;

use App\Enums\SpaPoolFilter;
use App\Models\CompanyTemplate;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CompanyTemplatesDataTable extends DataTable
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

        $dataTable->addColumn('name', function (CompanyTemplate $model) {
            return $model->name;
        });

        $dataTable->addColumn('client_level', function (CompanyTemplate $model) {
            return $model->client_level;
        });

        $dataTable->addColumn('meal_plan', function (CompanyTemplate $model) {
            return $model->mealPlan->name ?? '-';
        });

        $dataTable->addColumn('spa_pool_filter', function (CompanyTemplate $model) {
            return SpaPoolFilter::getDescription((int) $model->spa_pool_filter);
        });

        $dataTable->addColumn('vat', function (CompanyTemplate $model) {
            return $model->vat ? __('Yes') : __('No');
        });

        $dataTable->addColumn('language', function (CompanyTemplate $model) {
            return $model->language->name ?? '-';
        });

        $dataTable->addColumn('action', function (CompanyTemplate $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'companies.templates'
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
        $dataTable->orderColumn('name', static function ($query, $order) {
            $query->orderBy('name', $order);
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CompanyTemplate $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CompanyTemplate $model)
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
            ->setTableId('companies-templates-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lrtip')
            ->orderBy(1)
            ->lengthMenu(config('admin.datatable.length_menu'))
            ->pageLength(config('admin.datatable.page_length'))
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
            Column::make('name')->title(__('Template Name')),
            Column::make('client_level'),
            Column::make('meal_plan'),
            Column::make('spa_pool_filter')->title(__('Spa, Pool Filter')),
            Column::make('vat')->title(__('VAT'))
                ->addClass('text-center'),
            Column::make('language'),
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
        return 'CompanyTemplates_' . date('YmdHis');
    }
}
