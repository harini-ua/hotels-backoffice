<?php

namespace Database\Seeders;

use App\Models\BookingGuest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingGuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $booking_guests = [];

        if (($open = fopen(storage_path('app/seed') . "/booking_guests.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $booking_guests[] = [
                    'id' => (int)$data[0],
                    'booking_id' => (int)$data[6],
                    'firstname' => $data[2],
                    'lastname' => $data[3],
                    'guest_type' => $data[5] === 'adult' ? 0 : 1,
                    'child_age' => $data[5] === 'child' ? (int)$data[12] : null,
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($booking_guests, 1000) as $booking_guest) {
            DB::table(BookingGuest::TABLE_NAME)->insertTs($booking_guest);
        }
    }
}
