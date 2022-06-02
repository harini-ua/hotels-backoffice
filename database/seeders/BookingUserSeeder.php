<?php

namespace Database\Seeders;

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

//for booking_users.csv
//SELECT e.euserid, e.euser_title, e.euser_name, e.euser_lname, e.company_name, e.address, e.city, e.country_id, e.email, e.mobile, e.status, e.whtid, e.newsletter, e.phone_number, e.securePayment, e.invoice_allowed, e.distributor_id, e.partner_giftcard_id, e.hide_book_now, e.hide_my_account, e.partner_giftcard_code, l.langid, el.login_name, el.password_crypt, c.id as currency_id, e.sub_wht_id FROM end_user_profile e LEFT JOIN ml_tbl_language l ON l.langname = e.language LEFT JOIN euser_login_info el ON el.euserid = e.euserid LEFT JOIN tblcurrencyname c ON c.currencyname = e.currency
// WHERE e.whtid IN(761,804,805,806,807,808,809,810,840,841,842,843,844,845,846,847,848,849,1184,1395,1396,1397,1398,1399,1400,1401,1402,1403,1404,1418,1419,1420,1421,1422,1423,1556,1594,1706,1707,1708,1709,1710,1711,1712,1713,754,602,886,425,431,443,462,494,496,497,501,503,516,518,524,568,570,571,587,604,605,616,640,645,682,693,712,719,723,724,732,746,748,750,790,962,1374,1526,1554,1595,1623,1626,1629,1727,1743)
//AND e.sub_wht_id IN(0,2,3,5,6,10,18,19,23,30,31,32,33,34,36,46,47,48,52,63,65,68,72,74,76,79,80,82,83,87,89,90,177,178,179,173,174,175,176)
//used logic for password check
//$key = '$5$rounds=5000$stringheiusedforsalthotel$';
//$str = crypt($pass, $key);

        $booking_users = [];

        if (($open = fopen(storage_path('app/seed') . "/booking_users.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                $booking_users[] = [
                    'id' => $data[0],
                    'title' => $data[1] == NULL || $data[1] == '' ? 'Mr' : $data[1],
                    'username' => $data[22],
                    'firstname' => $data[2],
                    'lastname' => $data[3],
                    'email' => $data[8],
                    'password' => $data[23],
                    'status' => $data[10] == 'inactive' ? 0 : 1,
                    'hide_book_now' => (int)$data[18],
                    'hide_my_account' => (int)$data[19],
                    'invoice_allowed' => (int)$data[15],
                    'secure_payment' => (int)$data[14],
                    'newsletter' => (int)$data[12],
                    'company_name' => $data[4],
                    'address' => $data[5],
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
            DB::table('booking_users')->insertTs($booking_user);
        }
    }
}
