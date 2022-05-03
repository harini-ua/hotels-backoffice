<?php

namespace App\DataTables;

use App\Models\DiscountVoucher;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PopularHotelsDataTable extends DataTable
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

        $dataTable->addColumn('country', function (DiscountVoucher $model) {
            return $model->country->name;
        });

        $dataTable->addColumn('city', function (DiscountVoucher $model) {
            return $model->city->name;
        });

        $dataTable->addColumn('hotel', function (DiscountVoucher $model) {
            return $model->hotel->name;
        });

        $dataTable->addColumn('rating', function (DiscountVoucher $model) {
            return $model->rating;
        });


        $dataTable->addColumn('action', function (DiscountVoucher $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'popular-hotels'
            ]);
        });

        $this->setOrderColumns($dataTable);

        $dataTable->rawColumns([
            'rating'
        ]);

        $dataTable->filter(function ($query) {
            if ($this->request->has('country')) {
                $query->where('company_id', $this->request->get('country'));
            }
            if ($this->request->has('city')) {
                $query->where('city_id', $this->request->get('city'));
            }
            if ($this->request->has('hotel')) {
                $query->where('hotel_id', $this->request->get('hotel'));
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
     * @param \App\Models\DiscountVoucher $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DiscountVoucher $model)
    {
        return $model->newQuery()
            ->with(['country', 'city', 'hotel'])
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
            ->setTableId('popular-hotels-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rtip')
            ->orderBy(1)
            ->buttons(
                Button::make('postExcel'),
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
            Column::make('country'),
            Column::make('city'),
            Column::make('hotel'),
            Column::make('rating'),
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
        return 'PopularHotels_' . date('YmdHis');
    }
}
