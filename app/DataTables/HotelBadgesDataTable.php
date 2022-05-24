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

        $dataTable->addColumn('blacklisting', function (Hotel $model) {
            return '-';
        });

        $dataTable->addColumn('popular_hotel_rating', function (Hotel $model) {
            return '-';
        });

        $dataTable->addColumn('recommend_rating', function (Hotel $model) {
            return '-';
        });

        $dataTable->addColumn('special_price_rating', function (Hotel $model) {
            return '-';
        });

        $dataTable->addColumn('other_rating', function (Hotel $model) {
            return '-';
        });

        $dataTable->addColumn('hotel_commission', function (Hotel $model) {
            return '-';
        });

        $dataTable->addColumn('action', function (Hotel $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit'],
                'model' => $model,
                'route' => 'settings.hotel-badges'
            ]);
        });

        $this->setFilterColumns($dataTable);
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
            Column::make('hotel')->title(__('Hotel Name')),
            Column::make('blacklisting')->title(__('Blacklisting'))
                ->orderable(false)
                ->width(70)
                ->addClass('text-center'),
            Column::make('popular_hotel_rating')->title(__('Popular Hotel Rating'))
                ->orderable(false)
                ->width(130)
                ->addClass('text-center'),
            Column::make('recommend_rating')->title(__('Recommend Rating'))
                ->orderable(false)
                ->width(120)
                ->addClass('text-center'),
            Column::make('special_price_rating')->title(__('Special Price Rating'))
                ->orderable(false)
                ->width(120)
                ->addClass('text-center'),
            Column::make('other_rating')->title(__('Other Rating'))
                ->orderable(false)
                ->width(90)
                ->addClass('text-center'),
            Column::make('hotel_commission')->title(__('Hotel Commission'))
                ->orderable(false)
                ->width(110)
                ->addClass('text-center'),
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
