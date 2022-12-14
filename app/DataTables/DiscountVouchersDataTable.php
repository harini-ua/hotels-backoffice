<?php

namespace App\DataTables;

use App\Enums\DiscountAmountType;
use App\Enums\DiscountCodeType;
use App\Enums\DiscountCommissionType;
use App\Models\DiscountVoucher;
use App\Services\Formatter;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DiscountVouchersDataTable extends DataTable
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

        $dataTable->addColumn('name', function (DiscountVoucher $model) {
            return $model->name;
        });

        $dataTable->addColumn('company', function (DiscountVoucher $model) {
            return $model->company->company_name;
        });

        $dataTable->addColumn('voucher_type', function (DiscountVoucher $model) {
            return view("admin.pages.discount-vouchers.partials._voucher-type", compact('model'));
        });

        $dataTable->addColumn('voucher_codes_count', function (DiscountVoucher $model) {
            return $model->voucher_codes_count;
        });

        $dataTable->addColumn('amount', function (DiscountVoucher $model) {
            if ($model->amount_type == DiscountAmountType::Percent) {
                return $model->amount.' %';
            }

            if ($model->amount_type == DiscountAmountType::Fixed && $model->currency) {
                return Formatter::currency($model->amount).' '. $model->currency->code;
            }

            return Formatter::currency($model->amount);
        });

        $dataTable->addColumn('min_price', function (DiscountVoucher $model) {
            return Formatter::currency($model->min_price);
        });

        $dataTable->addColumn('commission', function (DiscountVoucher $model) {
            return DiscountCommissionType::getDescription($model->commission);
        });

        $dataTable->addColumn('expiry', function (DiscountVoucher $model) {
            return Formatter::date($model->expiry);
        });

        $dataTable->addColumn('voucher_code', function (DiscountVoucher $model) {
            return view("admin.pages.discount-vouchers.partials._voucher-code", compact('model'));

            if ((int) $model->voucher_type === DiscountCodeType::AccessForAll) {
                return $model->codes()->first()->code ?? '-';
            }

            return 'many';
        });

        $dataTable->addColumn('action', function (DiscountVoucher $model) {
            return view("admin.datatables.actions", [
                'actions' => ['edit', 'delete'],
                'model' => $model,
                'route' => 'discount-vouchers'
            ]);
        });

        $this->setOrderColumns($dataTable);

        $dataTable->rawColumns([
            'voucher_type',
            'voucher_code',
        ]);

        $dataTable->filter(function ($query) {
            if ($this->request->has('company')) {
                $query->where('company_id', $this->request->get('company'));
            }
            if ($this->request->has('voucher_type')) {
                $query->where('voucher_type', $this->request->get('voucher_type'));
            }
            if ($this->request->has('commission_type')) {
                $query->where('commission', $this->request->get('commission_type'));
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

        $dataTable->orderColumn('voucher_codes_count', static function ($query, $order) {
            $query->orderBy('voucher_codes_count', $order);
        });

        $dataTable->orderColumn('amount', static function ($query, $order) {
            $query->orderBy('amount', $order);
        });

        $dataTable->orderColumn('min_price', static function ($query, $order) {
            $query->orderBy('min_price', $order);
        });

        $dataTable->orderColumn('expiry', static function ($query, $order) {
            $query->orderBy('expiry', $order);
        });
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
            ->with(['company'])
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
            ->setTableId('discount-vouchers-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('lrtip')
            ->orderBy(1)
            ->lengthMenu(config('admin.datatable.length_menu'))
            ->pageLength(config('admin.datatable.page_length'))
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
            Column::make('id')->title(__('ID')),
            Column::make('name')->title(__('Name')),
            Column::make('company')->title(__('Company Site'))
                ->orderable(false),
            Column::make('voucher_type')->title(__('Voucher Type'))
                ->orderable(false),
            Column::make('voucher_codes_count')->title(__('Total codes'))
                ->addClass('text-center'),
            Column::make('amount')->title(__('Amount'))
                ->width(70)
                ->addClass('text-center'),
            Column::make('min_price')->title(__('Minimum Price'))
                ->width(70)
                ->addClass('text-center'),
            Column::make('commission')->title(__('Commission'))
                ->orderable(false),
            Column::make('expiry')->title(__('Expiry')),
            Column::make('voucher_code')->title(__('Codes'))
                ->orderable(false)
                ->width(160)
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
        return 'DiscountVouchers_' . date('YmdHis');
    }
}
