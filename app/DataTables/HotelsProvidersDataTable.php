<?php

namespace App\DataTables;

use App\Models\Hotel;
use App\Models\HotelProvider;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HotelsProvidersDataTable extends DataTable
{
    /** @var array */
    protected $providers;

    function __construct()
    {
        $this->providers = Provider::all()
            ->where('active', 1)
            ->pluck('name', 'id')
            ->toArray();
    }

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = datatables()->eloquent($query);

        $dataTable->addColumn('provider', function (Hotel $model) {
            return strtoupper($this->providers[$model->provider_id]);
        });

        $dataTable->addColumn('provider_hotel_code', function (Hotel $model) {
            return $model->provider_hotel_code;
        });

        $dataTable->addColumn('name', function (Hotel $model) {
            return $model->name;
        });

        $dataTable->addColumn('blacklisted', function (Hotel $model) {
            return view("admin.pages.hotels.partials._blacklist-switch", compact('model'));
        });

        $dataTable->addColumn('action', function (Hotel $model) {
            return view("admin.datatables.actions", ['actions' => ['save'], 'model' => $model]);
        });

        $this->setOrderColumns($dataTable);
        $this->setFilterColumns($dataTable);

        $dataTable->filter(function ($query) {
            if (!$this->request->hasAny(['country', 'city'])) {
                // Making the result empty on purpose
                $query->where('id', 0);
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
     * Get query source of dataTable.
     *
     * @param \App\Models\Hotel $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Hotel $model)
    {
        $query = $model->newQuery();

        $query->select([
            'hotels.id',
            'hotels.name',
            HotelProvider::TABLE_NAME.'.provider_id',
            HotelProvider::TABLE_NAME.'.provider_hotel_code',
            HotelProvider::TABLE_NAME.'.blacklisted',
        ]);

        $query->join(HotelProvider::TABLE_NAME, 'hotels.id', '=', HotelProvider::TABLE_NAME.'.hotel_id');

        if ($this->request->has('city')) {
            $query->where('hotels.city_id', $this->request->get('city'));
        }

        if ($this->request->has('provider')) {
            $query->where(HotelProvider::TABLE_NAME.'.provider_id', $this->request->get('provider'));
        }

        $query->orderBy('name', 'ASC');

        return $query;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('hotels-providers-list-datatable')
            ->addTableClass('table-striped table-bordered dtr-inline')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->responsive(true)
            ->language([
                'search' => '',
                'searchPlaceholder' => __('Search')
            ])
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
            Column::make('provider')->title(__('Provider')),
            Column::make('provider_hotel_code')->title(__('Provider Hotel Code')),
            Column::make('name')->title(__('Hotel Name')),
            Column::make('blacklisted')->title(__('Blacklisted'))
                ->width(70)
                ->addClass('column-edit text-center'),
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
        return 'HotelsProviders_' . date('YmdHis');
    }
}
