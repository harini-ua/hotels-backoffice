<?php

namespace App\DataTables;

use App\Enums\CompanyCategory;
use App\Enums\CompanyStatus;
use App\Models\Company;
use App\Services\Formatter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class CompaniesDataTable extends DataTable
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

        $dataTable->addColumn('name', function (Company $model) {
            return $model->company_name ?? '-';
        });

        $dataTable->addColumn('category', function (Company $model) {
            return CompanyCategory::getDescription($model->category);
        });

        $dataTable->addColumn('phone', function (Company $model) {
            return $model->phone ? '<a href="tel:'.$model->phone.'">'.$model->phone.'</a>' : '-';
        });

        $dataTable->addColumn('email', function (Company $model) {
            return $model->email ? '<a href="mailto:'.$model->email.'">'.$model->email.'</a>' : '-';
        });

        $dataTable->addColumn('city', function (Company $model) {
            return $model->city ? $model->city->name : '-';
        });

        $dataTable->addColumn('status', function (Company $model) {
            return view('admin.datatables.view-status', [
                'status' => CompanyStatus::getDescription($model->status),
                'class' => CompanyStatus::getColor($model->status, 'class'),
            ]);
        });

        $dataTable->addColumn('created_at', function (Company $model) {
            return Formatter::date($model->created_at);
        });

        $dataTable->addColumn('action', function (Company $model) {
            return view("admin.datatables.actions", ['actions' => ['duplicate', 'edit', 'delete'], 'model' => $model]);
        });

        $dataTable->rawColumns(['phone', 'email']);

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('status')) {
                $query->where('status', $this->request->get('status'));
            }
            if ($this->request->has('category')) {
                $query->where('category', $this->request->get('category'));
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
        $dataTable->orderColumn('company_name', static function ($query, $order) {
            $query->orderBy('company_name', $order);
        });
    }

    /**
     * Set filter columns
     *
     * @param $dataTable
     */
    protected function setFilterColumns($dataTable)
    {
        $dataTable->filterColumn('company_name', static function ($query, $keyword) {
            $query->where('company_name', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('phone', static function ($query, $keyword) {
            $query->where('phone', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('email', static function ($query, $keyword) {
            $query->where('email', 'like', "%$keyword%");
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Company $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Company $model)
    {
        return $model->newQuery()
            ->with(['city'])
        ;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('companies-list-datatable')
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
            Column::make('company_name')->title(__('Client Name')),
            Column::make('category')
                ->orderable(false),
            Column::make('phone')
                ->orderable(false),
            Column::make('email')
                ->orderable(false),
            Column::make('city')
                ->orderable(false),
            Column::make('status')
                ->orderable(false)
                ->addClass('text-center'),
            Column::make('created_at')->title(__('Added On')),
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
        return 'Companies_' . date('YmdHis');
    }
}
