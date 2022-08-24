<?php

namespace Database\Seeders;

use App\Models\HotelImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hotel_images = [];

        if (($open = fopen(storage_path('app/seed') . "/hotel_images.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                if (!empty($data[1]) && $data[1] !== 'NULL') {
                    $images = explode('#*#', $data[1]);
                    foreach ($images as $image) {
                        if (!empty($image)) {
                            $image = trim($image);
                            $hotel_images[] = [
                                'hotel_id' => (int)$data[0],
                                'image' => $image,
                                'primary' => 0,
                            ];
                        }
                    }
                }
                if ($data[2] !== '' && !strstr($data[2], 'no-image.png')) {
                    $hotel_images[] = [
                        'hotel_id' => (int)$data[0],
                        'image' => $data[2],
                        'primary' => 1,
                    ];
                }
            }

            fclose($open);
        }

        if (count($hotel_images) > 1000) {
            foreach (array_chunk($hotel_images, 1000) as $hotel_image) {
                DB::table(HotelImage::TABLE_NAME)->insertTs($hotel_image);
            }
        } else {
            DB::table(HotelImage::TABLE_NAME)->insertTs($hotel_images);
        }
    }
}
