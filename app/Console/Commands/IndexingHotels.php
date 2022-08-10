<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use Illuminate\Console\Command;

class IndexingHotels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'indexing:hotels
                            {--id=* : The id of the hotel}
                            {--city= : The id or name (en) of the city}
                            {--country= : The id or name (en) of the country}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexing hotels';

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
            $this->byHotelIds($this->option('id'));
        }

        if ($this->option('city')) {
            $this->byCity($this->option('city'));
        }

        if ($this->option('country')) {
            $this->byCountry($this->option('country'));
        }

        return 0;
    }

    /**
     * Indexing hotels by hotel id
     *
     * @param array $ids
     * @return void
     */
    protected function byHotelIds(array $ids)
    {
        /** @var Hotel $hotels */
        $hotels = Hotel::whereIn('id', $ids)->get();

        if ($hotels->count()) {
            $this->info('Indexing hotels ('.$hotels->count().'):');

            $rows = [];
            foreach ($hotels as $hotel) {
                $rows[] = [ $hotel->id, $hotel->name, $hotel->rating, $hotel->city_name, $hotel->country_name ];
            }

            $this->table(['ID', 'City', 'Rating', 'City', 'Country'], $rows);

            if ($this->confirm('Do you wish to continue?')) {
                $hotels->searchable();
            }
        } else {
            $this->info('No hotels found');
        }
    }

    /**
     * Indexing hotels by city id
     *
     * @param int $city
     * @return void
     */
    protected function byCity(int $city)
    {
        /** @var City $city */
        $city = City::find('id', $city)->first();
        if ($city) {
            /** @var Hotel $hotels */
            $hotels = Hotel::where('city_id', $city->id)->get();

            if ($hotels->count()) {
                $this->info('Indexing hotels (' . $hotels->count() . '):');
                if ($this->confirm('Do you wish to continue?')) {
                    $hotels->searchable();
                }
            } else {
                $this->info('No hotels found');
            }
        } else {
            $this->info('No city found');
        }
    }

    /**
     * Indexing hotels by country id or country name
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
            /** @var Hotel $hotels */
            $hotels = Hotel::where('country_id', $country->id)->get();

            if ($hotels->count()) {
                $this->info('Indexing hotels (' . $hotels->count() . '):');
                if ($this->confirm('Do you wish to continue?')) {
                    $hotels->searchable();
                }
            } else {
                $this->info('No hotels found');
            }
        } else {
            $this->info('No country found');
        }
    }
}
