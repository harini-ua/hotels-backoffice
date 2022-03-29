<?php

namespace App\Widgets;

use App\Models\Distributor;
use Arrilot\Widgets\AbstractWidget;

class Distributors extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $count = Distributor::count();

        return view('admin.widgets.distributors', [
            'config' => $this->config,
            'count' => $count
        ]);
    }
}
