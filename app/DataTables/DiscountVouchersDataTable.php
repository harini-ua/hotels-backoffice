<?php

namespace App\DataTables;

use App\Enums\DiscountAmountType;
use App\Enums\DiscountCodeType;
use App\Enums\DiscountCommissionType;
use App\Models\CompanyTheme;
use App\Models\DiscountVoucher;
use App\Models\User;
use App\Services\Formatter;
use Carbon\Carbon;
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

        $dataTable->addColumn('name', function(DiscountVoucher $model) {
            return $model->name;
        });

        $dataTable->addColumn('company', function(DiscountVoucher $model) {
            return $model->company->company_name;
        });

        $dataTable->addColumn('voucher_type', function(DiscountVoucher $model) {
            return view("admin.pages.discount-vouchers.partials._voucher-type", compact('model'));
        });

        $dataTable->addColumn('voucher_codes_count', function(DiscountVoucher $model) {
            return $model->voucher_codes_count;
        });

        $dataTable->addColumn('amount', function(DiscountVoucher $model) {
            if ($model->amount_type == DiscountAmountType::Percent) {
                return $model->amount.' %';
            }

            if ($model->amount_type == DiscountAmountType::Fixed && $model->currency) {
                return Formatter::currency($model->amount).' '. $model->currency->code;
            }

            return Formatter::currency($model->amount);
        });

        $dataTable->addColumn('min_price', function(DiscountVoucher $model) {
            return Formatter::currency($model->min_price);
        });

        $dataTable->addColumn('commission', function(DiscountVoucher $model) {
            return DiscountCommissionType::getDescription($model->commission);
        });

        $dataTable->addColumn('expiry', function(DiscountVoucher $model) {
            return Formatter::date($model->expiry);
        });

        $dataTable->addColumn('voucher_code', function(DiscountVoucher $model) {
            return view("admin.pages.discount-vouchers.partials._voucher-code", compact('model'));

            if ($model->voucher_type == DiscountCodeType::AccessForAll) {
                return $model->codes()->first()->code;
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

        $dataTable->rawColumns([
            'voucher_type',
            'voucher_code',
        ]);

        $dataTable->filter(function($query) {
            if ($this->request->has('company')) {
                // TODO: Implement filter by company
            }
            if ($this->request->has('discount_type')) {
                // TODO: Implement filter by discount type
            }
            if ($this->request->has('commission_type')) {
                // TODO: Implement filter by commission type
            }
        }, true);

        return $dataTable;
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
            Column::make('id')->title(__('ID'))->orderable(false),
            Column::make('name')->title(__('Name')),
            Column::make('company')->title(__('Company Site')),
            Column::make('voucher_type')->title(__('Voucher Type')),
            Column::make('voucher_codes_count')->title(__('Total codes'))
                ->addClass('text-center'),
            Column::make('amount')->title(__('Amount')),
            Column::make('min_price')->title(__('Minimum Price')),
            Column::make('commission')->title(__('Commission')),
            Column::make('expiry')->title(__('Expiry')),
            Column::make('voucher_code')->title(__('Codes'))
                ->width(160)
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
        return 'DiscountVouchers_' . date('YmdHis');
    }
}
