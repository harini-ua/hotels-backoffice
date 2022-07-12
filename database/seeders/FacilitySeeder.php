<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(Facility::TABLE_NAME)->insertTs(
            [
                [ 'name' => 'ac' ],
                [ 'name' => 'room_tv' ],
                [ 'name' => 'bathroom' ],
                [ 'name' => 'shower' ],
                [ 'name' => 'hairdryer' ],
                [ 'name' => 'room_phone' ],
                [ 'name' => 'internet' ],
                [ 'name' => 'bar' ],
                [ 'name' => 'tea_coffee' ],
                [ 'name' => 'elevators' ],
                [ 'name' => 'laptop' ],
                [ 'name' => 'voltage' ],
                [ 'name' => 'safebox' ],
                [ 'name' => 'roomservice' ],
                [ 'name' => 'businessfacilities' ],
                [ 'name' => 'concierge' ],
                [ 'name' => 'petallowed' ],
                [ 'name' => 'porterage' ],
                [ 'name' => 'pool' ],
                [ 'name' => 'restaurant' ],
                [ 'name' => 'sauna' ],
                [ 'name' => 'gym' ],
                [ 'name' => 'wheelchair' ],
                [ 'name' => 'fax' ],
                [ 'name' => 'centralheating' ],
                [ 'name' => 'bellboy' ],
                [ 'name' => 'wifi' ],
                [ 'name' => 'breakfast_included' ],
                [ 'name' => 'satellite_tv' ],
                [ 'name' => 'parking' ],
                [ 'name' => 'non_smoking_rooms' ],
                [ 'name' => 'tennis' ],
                [ 'name' => 'garden' ],
                [ 'name' => 'golf' ],
                [ 'name' => 'carcharging' ],
                [ 'name' => 'spa' ],
                [ 'name' => 'professional_staff' ],
                [ 'name' => 'smoke_free' ],
                [ 'name' => 'roof_terrace' ],
                [ 'name' => 'complimentary_newspaper' ],
                [ 'name' => 'tour_desk' ],
            ]
        );
    }
}
