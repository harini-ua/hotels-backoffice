<?php

namespace App\DataTables;

use App\Models\Hotel;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HotelBadgesDataTable extends DataTable
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

        $dataTable->addColumn('hotel', function (Hotel $model) {
            return $model->name;
        });

        $dataTable->addColumn('action', function (Hotel $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit'],
                'model' => $model,
                'route' => 'settings.hotel-badges'
            ]);
        });

        $this->setOrderColumns($dataTable);

        $dataTable->filter(function ($query) {
            if (!$this->request->hasAny(['country', 'city'])) {
                // Making the result empty on purpose
                $query->where('hotels.id', 0);
            }
            if ($this->request->has('country')) {
                $query->where('country_id', $this->request->get('country'));
            }
            if ($this->request->has('city')) {
                $query->where('city_id', $this->request->get('city'));
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
        //
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Hotel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Hotel $model)
    {
        return $model->newQuery()
            ->with([])
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
            ->setTableId('hotel-badges-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('frtip')
            ->orderBy(0)
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
            Column::make('hotel'),
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
        return 'HotelBadges_' . date('YmdHis');
    }
}
