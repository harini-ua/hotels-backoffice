<?php

namespace App\DataTables;

use App\Enums\IpFilterType;
use App\Models\IpFilter;
use App\Services\Formatter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class IpFilterDataTable extends DataTable
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

        $dataTable->addColumn('type', function (IpFilter $model) {
            return view('admin.datatables.view-status', [
                'status' => IpFilterType::getDescription($model->type),
                'class' => IpFilterType::getColor($model->type, 'class'),
            ]);
        });

        $dataTable->addColumn('ip_address', function (IpFilter $model) {
            return $model->ip_address;
        });

        $dataTable->addColumn('comment', function (IpFilter $model) {
            return $model->comment;
        });

        $dataTable->addColumn('creator_id', function (IpFilter $model) {
            return $model->creator->fullname;
        });

        $dataTable->addColumn('expiry', function (IpFilter $model) {
            return $model->expiry ? Formatter::date($model->expiry) : '-';
        });

        $dataTable->addColumn('action', function (IpFilter $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'settings.ip-filter'
            ]);
        });

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
        $dataTable->orderColumn('type', static function ($query, $order) {
            $query->orderBy('type', $order);
        });

        $dataTable->orderColumn('expiry', static function ($query, $order) {
            $query->orderBy('expiry', $order);
        });
    }

    /**
     * Set filter columns
     *
     * @param $dataTable
     */
    protected function setFilterColumns($dataTable)
    {
        $dataTable->filterColumn('ip_address', static function ($query, $keyword) {
            $query->where('ip_address', 'like', "%$keyword%");
        });

        $dataTable->filterColumn('comment', static function ($query, $keyword) {
            $query->where('comment', 'like', "%$keyword%");
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\IpFilter $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(IpFilter $model)
    {
        return $model->newQuery()
            ->with(['creator']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('ip-filter-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
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
                Button::make('print'),
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id')->title(__('#'))
                ->width(50),
            Column::make('ip_address')->title(__('IP Address'))
                ->width(150)
                ->orderable(false),
            Column::make('type')->title(__('Type List'))
                ->width(150),
            Column::make('comment')->title(__('Comment'))->orderable(false),
            Column::make('creator_id')->title(__('Creator'))
                ->width(250)
                ->orderable(false),
            Column::make('expiry')->title(__('Expiry'))
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
        return 'IpsFilter_' . date('YmdHis');
    }
}
