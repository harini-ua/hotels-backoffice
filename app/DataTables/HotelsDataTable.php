<?php

namespace App\DataTables;

use App\Models\Hotel;
use App\Models\HotelProvider;
use App\Models\Provider;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class HotelsDataTable extends DataTable
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

        $dataTable->addColumn('tti_code', function (Hotel $model) {
            return $model->tti_code ?? '-';
        });

        $dataTable->addColumn('providers', function (Hotel $model) {
            $providers = [];
            foreach (explode(',', $model->providers) as $provider_id) {
                if (isset($this->providers[$provider_id])) {
                    $providers[] = strtoupper($this->providers[$provider_id]);
                }
            }

            return $providers ? implode(', ', $providers) : '-';
        });

        $dataTable->addColumn('name', function (Hotel $model) {
            return $model->name;
        });

        $dataTable->addColumn('commission', function (Hotel $model) {
            return view("admin.pages.hotels.partials._commission-edit", compact('model'));
        });

        $dataTable->addColumn('blacklisted', function (Hotel $model) {
            return view("admin.pages.hotels.partials._blacklist-switch", compact('model'));
        });

        $dataTable->addColumn('action', function (Hotel $model) {
            return view("admin.datatables.actions", ['actions' => ['save', 'edit'], 'model' => $model]);
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

        $dataTable->filterColumn('tti_code', static function ($query, $keyword) {
            $query->where('tti_code', 'like', "%$keyword%");
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
        $query->select([ 'hotels.id', 'hotels.city_id', 'hotels.name']);
        $query->selectRaw('hotel_providers.providers AS providers');
        $query->selectRaw('hotel_providers.tti_code AS tti_code');

        $hotel_providers = DB::table(HotelProvider::TABLE_NAME)
            ->select(['hotel_id', DB::raw('GROUP_CONCAT(DISTINCT(provider_id)) providers'), 'tti_code'])
            ->groupBy('hotel_id');

        $query->leftJoinSub($hotel_providers, 'hotel_providers', static function($join) {
            $join->on('hotels.id', '=', 'hotel_providers.hotel_id');
        });

        if ($this->request->has('city')) {
            $query->where('hotels.city_id', $this->request->get('city'));
        }

        $query->orderBy('hotels.name', 'ASC');

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
            ->setTableId('hotels-list-datatable')
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
            Column::make('id')->title(__('Hotel Code'))
                ->width(70)
                ->addClass('text-center'),
            Column::make('tti_code')->title(__('TTI Code'))
                ->orderable(false),
            Column::make('providers')->title(__('Providers'))
                ->orderable(false),
            Column::make('name')->title(__('Hotel Name')),
            Column::make('commission')->title(__('Commission'))
                ->width(100)
                ->addClass('column-edit'),
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
        return 'Hotels_' . date('YmdHis');
    }
}
