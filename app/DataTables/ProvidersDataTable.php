<?php

namespace App\DataTables;

use App\Models\Provider;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProvidersDataTable extends DataTable
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

        $dataTable->addColumn('name', function (Provider $model) {
            return $model->name;
        });

        $dataTable->addColumn('email', function (Provider $model) {
            return $model->email ? '<a href="mailto:'.$model->email.'">'.$model->email.'</a>' : '-';
        });

        $dataTable->addColumn('support_phone', function (Provider $model) {
            return $model->support_phone ? '<a href="tel:'.$model->support_phone.'">'.$model->support_phone.'</a>' : '-';
        });

        $dataTable->addColumn('active', function (Provider $model) {
            return view("admin.pages.providers.partials._active-switch", compact('model'));
        });

        $dataTable->addColumn('action', function (Provider $model) {
            return view("admin.datatables.actions", ['actions' => ['edit'], 'model' => $model]);
        });

        $dataTable->rawColumns(['email', 'support_phone', 'active']);

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
     * @param \App\Models\Provider $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Provider $model)
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
            ->setTableId('providers-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Brtip')
            ->orderBy(1)
            ->responsive(true)
            ->buttons(
                Button::make('excel'),
                Button::make('print'),
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
                ->width(50)
                ->addClass('text-center'),
            Column::make('name')->title(__('Provider Name')),
            Column::make('email')
                ->orderable(false),
            Column::make('support_phone')
                ->orderable(false),
            Column::make('active')
                ->orderable(false)
                ->width(70)
                ->addClass('text-center'),
            Column::computed('action')
                ->orderable(false)
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->width(70)
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
        return 'Provides_' . date('YmdHis');
    }
}
