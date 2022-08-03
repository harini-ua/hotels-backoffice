<?php

namespace App\DataTables;

use App\Enums\PromoMessageStatus;
use App\Models\PromoMessage;
use App\Services\Formatter;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PromoMessagesDataTable extends DataTable
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

        $dataTable->addColumn('headline', function (PromoMessage $model) {
            return $model->headline;
        });

        $dataTable->addColumn('company', function (PromoMessage $model) {
            if ($model->show_all_company === 0) {
                return __('All');
            }

            return $model->companies ?
                implode(', ', $model->companies->pluck('company_name')->toArray())
                : '-';
        });

        $dataTable->addColumn('language', function (PromoMessage $model) {
            return $model->language->name;
        });

        $dataTable->addColumn('status', function (PromoMessage $model) {
            return view('admin.datatables.view-status', [
                'status' => PromoMessageStatus::getDescription((int) $model->status),
                'class' => PromoMessageStatus::getColor($model->status, 'class'),
            ]);
        });

        $dataTable->addColumn('creator', function (PromoMessage $model) {
            return $model->creator->fullname;
        });

        $dataTable->addColumn('expiry_date', function (PromoMessage $model) {
            return Formatter::date($model->expiry_date);
        });

        $dataTable->addColumn('action', function (PromoMessage $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'promo-messages'
            ]);
        });

        $dataTable->rawColumns([
            'status',
        ]);

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        return $dataTable;
    }

    /**
     * Set order columns
     *
     * @param $dataTable
     */
    protected function setOrderColumns($dataTable)
    {
        $dataTable->orderColumn('expiry_date', static function ($query, $order) {
            $query->orderBy('expiry_date', $order);
        });
    }

    /**
     * Set filter columns
     *
     * @param $dataTable
     */
    protected function setFilterColumns($dataTable)
    {
        $dataTable->filterColumn('headline', static function ($query, $keyword) {
            $query->where('headline', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('content', static function ($query, $keyword) {
            $query->where('content', 'like', "%$keyword%");
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PromoMessage $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PromoMessage $model)
    {
        return $model->newQuery()
            ->with(['language', 'creator'])
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
            ->setTableId('promo-messages-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lrtip')
            ->orderBy(1)
            ->lengthMenu(config('admin.datatable.length_menu'))
            ->pageLength(config('admin.datatable.page_length'))
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
            Column::make('headline')->title(__('Title'))->orderable(false),
            Column::make('company')->title(__('Company'))->orderable(false),
            Column::make('language')->title(__('Language'))->orderable(false),
            Column::make('creator')->title(__('Creator'))->orderable(false),
            Column::make('status')->title(__('Status'))->orderable(false),
            Column::make('expiry_date')->title(__('Expiry Date')),
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
        return 'PromoMessages_' . date('YmdHis');
    }
}
