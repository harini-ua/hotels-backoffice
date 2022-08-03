<?php

namespace App\DataTables;

use App\Models\Currency;
use App\Models\MealPlan;
use App\Models\Partner;
use App\Models\PartnerProduct;
use App\Services\Formatter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class PartnerProductsDataTable extends DataTable
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

        $dataTable->addColumn('partner', function (PartnerProduct $model) {
            return $model->partner_id ? Partner::find($model->partner_id)->name : '-';
        });

        $dataTable->addColumn('name', function (PartnerProduct $model) {
            return $model->name ?? '-';
        });

        $dataTable->addColumn('code', function (PartnerProduct $model) {
            return $model->code ?? '-';
        });

        $dataTable->addColumn('meal_plan', function (PartnerProduct $model) {
            return $model->meal_plan_id ? MealPlan::find($model->meal_plan_id)->name : '-';
        });

        $dataTable->addColumn('price', function (PartnerProduct $model) {
            return Formatter::currency($model->price) ?? '-';
        });

        $dataTable->addColumn('currency', function (PartnerProduct $model) {
            return $model->currency_id ? Currency::find($model->currency_id)->code : '-';
        });

        $dataTable->addColumn('price_min', function (PartnerProduct $model) {
            return Formatter::currency($model->price_min) ?? '-';
        });

        $dataTable->addColumn('price_max', function (PartnerProduct $model) {
            return Formatter::currency($model->price_max) ?? '-';
        });

        $dataTable->addColumn('sku', function (PartnerProduct $model) {
            return $model->sku ?? '-';
        });

        $dataTable->addColumn('action', function (PartnerProduct $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'partners.products'
            ]);
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if ($this->request->has('partner')) {
                $query->where('partner_id', $this->request->get('partner'));
            }
            if ($this->request->has('meal_plan')) {
                $query->where('meal_plan_id', $this->request->get('meal_plan'));
            }
            if ($this->request->has('currency')) {
                $query->where('currency_id', $this->request->get('currency'));
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

        $dataTable->orderColumn('price', static function ($query, $order) {
            $query->orderBy('price', $order);
        });

        $dataTable->orderColumn('price_min', static function ($query, $order) {
            $query->orderBy('price_min', $order);
        });

        $dataTable->orderColumn('price_max', static function ($query, $order) {
            $query->orderBy('price_max', $order);
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
            $query->orWhere('code', 'like', "%$keyword%");
            $query->orWhere('sku', 'like', "%$keyword%");
        });
    }

    /**s
     * Get query source of dataTable.
     *
     * @param \App\Models\PartnerProduct $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PartnerProduct $model)
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
            ->setTableId('partners-products-list-datatable')
            ->addTableClass('table table-striped table-bordered dataTable no-footer dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lBfrtip')
            ->orderBy(0)
            ->lengthMenu(config('admin.datatable.length_menu'))
            ->pageLength(config('admin.datatable.page_length'))
            ->buttons(
                Button::make('excel'),
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
            Column::make('partner')->title(__('Partner'))
                ->orderable(false),
            Column::make('name')->title(__('Product Name')),
            Column::make('code')->title(__('Product Code'))
                ->orderable(false),
            Column::make('meal_plan')->title(__('Meal Plan'))
                ->orderable(false),
            Column::make('price')->title(__('Product Price')),
            Column::make('currency')->title(__('Currency'))
                ->orderable(false),
            Column::make('price_min')->title(__('Min Price')),
            Column::make('price_max')->title(__('Max Price')),
            Column::make('sku')->title(__('SKU'))
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
        return 'PartnerProducts_' . date('YmdHis');
    }
}
