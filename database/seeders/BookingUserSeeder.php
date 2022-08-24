<?php

namespace Database\Seeders;

use App\Models\BookingUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $booking_users = [];

        if (($open = fopen(storage_path('app/seed') . "/booking_users.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $booking_users[] = [
                    'id' => $data[0],
                    'title' => in_array($data[1], ['-', 'N/A', 'NULL', ''], true) || $data[1] == null ? 'Mr' : $data[1],
                    'username' => $data[22],
                    'firstname' => $data[2],
                    'lastname' => $data[3],
                    'email' => $data[8],
                    'password' => $data[23],
                    'status' => $data[10] === 'inactive' ? 0 : 1,
                    'hide_book_now' => (int)$data[18],
                    'hide_my_account' => (int)$data[19],
                    'invoice_allowed' => (int)$data[15],
                    'secure_payment' => (int)$data[14],
                    'newsletter' => (int)$data[12],
                    'company_name' => in_array($data[4], ['-', 'N/A', 'NULL', '.', ''], true) || $data[4] == null ? null : $data[4],
                    'address' => in_array($data[5], ['-', 'N/A', 'NULL', ''], true) || $data[5] == null ? null : $data[5],
                    'phone' => $data[9],
                    'distributor_id' => !(int)$data[16] ? NULL : (int)$data[16],
                    'company_id' => (int)$data[11],
                    'country_id' => (int)$data[7],
                    'city' => $data[6],
                    'language_id' => !(int)$data[21] ? 1 : (int)$data[21],
                    'currency_id' => !(int)$data[24] ? 1 : (int)$data[24],
                    'partner_gitfcard_id' => $data[17] == '' || $data[17] == '0' ? NULL : $data[17],
                    'partner_gitfcard_code' => $data[20] == '' || $data[20] == '0' ? NULL : $data[20],
                    'sub_company_id' => !(int)$data[25] ? NULL : (int)$data[25],
                ];
            }

            fclose($open);
        }

        foreach (array_chunk($booking_users, 1000) as $booking_user) {
            DB::table(BookingUser::TABLE_NAME)->insertTs($booking_user);
        }
    }
}
