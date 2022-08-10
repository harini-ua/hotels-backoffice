<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Country;
use Illuminate\Console\Command;

class IndexingCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'indexing:cities
                            {--id=* : The id of the city}
                            {--country= : The id or name (en) of the country}
                            {--region= : The name (en) of the region (Europe, Africa)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexing cities';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('id')) {
            $this->byCityIds($this->option('id'));
        }

        if ($this->option('country')) {
            $this->byCountry($this->option('country'));
        }

        if ($this->option('region')) {
            $this->byRegion($this->option('region'));
        }

        return 1;
    }

    /**
     * Indexing cities by city id
     *
     * @param array $ids
     * @return void
     */
    protected function byCityIds(array $ids)
    {
        /** @var City $cities */
        $cities = City::whereIn('id', $ids)->with('country')->get();
        if ($cities->count()) {
            $this->info('Indexing cities ('.$cities->count().'):');

            $rows = [];
            foreach ($cities as $city) {
                $rows[] = [ $city->id, $city->name, $city->country->name ];
            }

            $this->table(['ID', 'City', 'Country'], $rows);

            if ($this->confirm('Do you wish to continue?')) {
                $cities->searchable();
            }
        } else {
            $this->info('No cities found');
        }
    }

    /**
     * Indexing cities by country id or country name
     *
     * @param $country
     * @return void
     */
    protected function byCountry($country)
    {
        if (filter_var($country, FILTER_VALIDATE_INT) === true) {
            $country = Country::find($country);
        } else {
            $country = Country::where('name', $country)->first();
        }

        if ($country) {
            /** @var City $cities */
            $cities = City::where('country_id', $country->id)->get();

            if ($cities->count()) {
                $this->info('Indexing cities (' . $cities->count() . '):');
                if ($this->confirm('Do you wish to continue?')) {
                    $cities->searchable();
                }
            } else {
                $this->info('No cities found');
            }
        } else {
            $this->info('No country found');
        }
    }

    /**
     * Indexing cities by region
     *
     * @param string $region
     * @return void
     */
    protected function byRegion(string $region)
    {
        $countries = Country::where('region', $region)->get();

        if ($countries->count()) {
            $total = 0;
            foreach ($countries as $country) {
                $total += City::where('country_id', $country->id)->count();
            }

            if ($total) {
                $this->info('Indexing cities (' . $total . '):');
                if ($this->confirm('Do you wish to continue?')) {
                    foreach ($countries as $country) {
                        $cities = City::where('country_id', $country->id)->get();
                        $cities->searchable();
                    }
                }
            } else {
                $this->info('No cities found');
            }
        } else {
            $this->info('No region found');
        }
    }
}
