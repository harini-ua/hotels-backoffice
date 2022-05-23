<?php

namespace App\DataTables;

use App\Models\Distributor;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DistributorsDataTable extends DataTable
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

        $dataTable->addColumn('name', function (Distributor $model) {
            return $model->name ?? '-';
        });

        $dataTable->addColumn('company', function (Distributor $model) {
            return implode(', ', $model->companies->pluck('company_name')->toArray());
        });

        $dataTable->addColumn('country', function (Distributor $model) {
            return implode(', ', $model->countries->pluck('name')->toArray());
        });

        $dataTable->addColumn('language', function (Distributor $model) {
            return implode(', ', $model->languages->pluck('name')->toArray());
        });

        $dataTable->addColumn('action', function (Distributor $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model
            ]);
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('company')) {
                $query->whereHas('companies', function ($q) {
                    $q->where('companies.id', $this->request->get('company'));
                });
            }
            if ($this->request->has('country')) {
                $query->whereHas('countries', function ($q) {
                    $q->where('countries.id', $this->request->get('country'));
                });
            }
            if ($this->request->has('language')) {
                $query->whereHas('languages', function ($q) {
                    $q->where('languages.id', $this->request->get('language'));
                });
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
     * @param \App\Models\Distributor $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Distributor $model)
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
            ->setTableId('distributors-list-datatable')
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
            Column::make('id')->title(__('ID')),
            Column::make('name')->title(__('Distributor Name'))
                ->orderable(false),
            Column::make('company')->title(__('Company Site'))
                ->orderable(false),
            Column::make('country')->title(__('Countries'))
                ->orderable(false),
            Column::make('language')->title(__('Languages'))
                ->orderable(false),
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
        return 'Distributors_' . date('YmdHis');
    }
}
