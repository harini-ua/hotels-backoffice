<?php

namespace App\DataTables;

use App\Models\Hotel;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class RecommendedHotelsDataTable extends DataTable
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

        $dataTable->addColumn('country', function (Hotel $model) {
            return $model->city->country->name;
        });

        $dataTable->addColumn('city', function (Hotel $model) {
            return $model->city->name;
        });

        $dataTable->addColumn('hotel', function (Hotel $model) {
            return $model->name;
        });

        $dataTable->addColumn('sort', function (Hotel $model) {
            return $model->recommended;
        });

        $dataTable->addColumn('action', function (Hotel $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'settings.recommended-hotels'
            ]);
        });

        $this->setOrderColumns($dataTable);

        $dataTable->rawColumns([
            'sort'
        ]);

        $dataTable->filter(function ($query) {
//            if ($this->request->has('country')) {
//                $query->where('country_id', $this->request->get('country'));
//            }
//            if ($this->request->has('city')) {
//                $query->where('city_id', $this->request->get('city'));
//            }
            if ($this->request->has('sort')) {
                $query->where('sort', $this->request->get('sort'));
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
            ->with(['city.country'])
            ->where('recommended', '>', 0)
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
            ->setTableId('recommended-hotels-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lrtip')
            ->orderBy(2)
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
            Column::make('country'),
            Column::make('city'),
            Column::make('hotel'),
            Column::make('sort')
                ->width(100)
                ->addClass('text-center'),
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
        return 'RecommendedHotels_' . date('YmdHis');
    }
}
