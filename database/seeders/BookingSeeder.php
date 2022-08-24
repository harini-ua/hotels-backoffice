<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\DiscountVoucherCode;
use App\Models\Hotel;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bookings = [];

        if (($open = fopen(storage_path('app/seed') . "/bookings.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {
                //remove this condition before full seeding Database
                if ((Hotel::find((int)$data[10]) && !(int)$data[31]) || (Hotel::find((int)$data[10]) && ((int)$data[31] && DiscountVoucherCode::find((int)$data[31])))) {
                    preg_match_all('!\d+!', $data[16], $refundable);
                    $cancellation_date = null;
                    if ((int)$data[14] && (int)$data[15]) {
                        $date = str_replace('/', '-', $data[14]);
                        $time = str_replace('AM', '', str_replace('PM', '', $data[15]));
                        $date = strstr($date, '-') ? $date : substr_replace(substr_replace($date, '-', 4, 0), '-', 7, 0);
                        $time = strstr($time, ':') ? $date : substr_replace($time, ':', 2, 0);
                        $cancellation_date = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));
                    }
                    $roomType = $data[11];
                    $roomType = rtrim($roomType, ',');
                    $roomType = preg_replace('/(?<!\d),|,(?!\d{3})/', ', ', $roomType);
                    $roomType = str_replace(
                        array('   ', '  ',  '),(', '()',  ')(', ' ,',  'e(',  'd(',  'm(',),
                        array(  ' ',  ' ', '), (',  ' ', ') (',  ',', 'e (', 'd (', 'm (',),
                        $roomType
                    );

                    $bookings[] = [
                        'id' => (int)$data[0],
                        'provider_id' => (int)$data[1],
                        'booking_reference' => $data[3] === 'N/A' || $data[3] === 'NULL' || $data[3] == '' ? null : $data[3],
                        'booking_cancel_reference' => $data[4] === 'NULL' || $data[4] == '' ? null : $data[4],
                        'booking_hash' => in_array($data[55], ['NULL', '', ' '], true) || $data[55] == null ? Uuid::uuid1() : $data[55],
                        'payment_type' => (int)$data[5],
                        'status' => $data[6] === 'CONFIRMED' ? 1 : ($data[6] === 'Cancelled' ? 2 : ($data[6] === 'Paid, but not confirmed' ? 3 : ($data[6] === 'Not Paid' ? 4 : 0))),
                        'item_code' => $data[7] === 'NULL' || $data[7] == '' ? null : $data[7],
                        'checkin' => date('Y-m-d', strtotime(str_replace('/', '-', $data[8]))),
                        'checkout' => date('Y-m-d', strtotime(str_replace('/', '-', $data[9]))),
                        'hotel_id' => (int)$data[10],
                        'room_type' => $roomType,
                        'rooms' => (int)$data[12],
                        'nights' => (int)$data[13],
                        'cancellation_date' => $cancellation_date,
                        'cancelled_date' => $data[34] == null ? null : date('Y-m-d', strtotime($data[34])),
                        'cancellation_policy' => $data[16] === 'NULL' || $data[16] == null || $data[16] == '' ? null : $data[16],
                        'refundable_status' => empty($refundable[0]) ? 0 : 1,
                        'booking_user_id' => (int)$data[18],
                        'inn_off_code' => $data[19] === 'NULL' || $data[19] == '' ? null : $data[19],
                        'adults' => (int)$data[20],
                        'children' => (int)$data[21],
                        'remarks' => $data[22] === 'NULL' || $data[22] == '' ? null : $data[22],
                        'customer_name' => $data[23] === 'NULL' || $data[23] == null || $data[23] == '' ? null : $data[23],
                        'customer_email' => $data[24] === 'NULL' || $data[24] == null || $data[24] == '' ? null : $data[24],
                        'customer_phone' => $data[25] === 'NULL' || $data[25] == null || $data[25] == '' ? null : $data[25],
                        'amount' => (float)$data[26],
                        'amount_conversion' => (float)$data[47],
                        'commission' => (float)$data[27],
                        'final_amount' => (float)$data[28],
                        'final_amount_conversion' => (float)$data[28]*(float)$data[30],
                        'original_currency_id' => 1,
                        'selected_currency_id' => !(int)$data[29] ? 1 : (int)$data[29],
                        'conversion_rate' => (float)$data[30],
                        'discount_voucher_code_id' => !(int)$data[31] ? null : (int)$data[31],
                        'room_rate_key' => $data[32] === 'NULL' ? null : $data[32],
                        'payment_reference' => $data[33] === 'NULL' ? null : $data[33],
                        'created_at' => Carbon::parse($data[2]),
                        'platform_type' => !(int)$data[35] || (int)$data[35] > 4 ? 2 : (int)$data[35],
                        'platform_version' => $data[36] === 'NULL' || $data[36] == null || $data[36] == '' ? null :$data[36],
                        'platform_details' => $data[37] === 'NULL' || $data[37] == null || $data[37] == '' ? null :$data[37],
                        'country_id' => !(int)$data[38] ? null : (int)$data[38],
                        'city_id' => !(int)$data[39] ? null : (int)$data[39],
                        'company_id' => !(int)$data[40] ? null : (int)$data[40],
                        'sub_company_id' => (int)$data[41] == 0 ? null : (int)$data[41],
                        'partner_amount' => !(float)$data[42] ? null : (float)$data[42],
                        'partner_currency_id' => (int)$data[43] == 0 ? null : (int)$data[43],
                        'vat' => !(float)$data[44] ? null : (float)$data[44],
                        'pay_to_client' => !(float)$data[45] ? null : (float)$data[45],
                        'sales_office_commission' => !(float)$data[46] ? null : (float)$data[46],
                        'sub_company_commission' => !(float)$data[50] ? null : (float)$data[50],
                        'mail_flag' => (int)$data[48],
                        'extra_nights' => (int)$data[49],
                        'discount_amount' =>  !(float)$data[51] ? null : (float)$data[51],
                        'additional_booking_reference' => $data[52] === 'N/A' || $data[52] === 'NULL' || $data[52] == null || $data[52] == '' ? null : $data[52],
                        'supplier_name' => $data[53] === 'NULL' || $data[53] == null || $data[53] == '' ? null : $data[53],
                        'vat_number' => $data[54] === 'NULL' || $data[54] == null || $data[54] == '' ? null : trim($data[54]),
                    ];
                }
            }

            fclose($open);
        }

        foreach (array_chunk($bookings, 1000) as $booking) {
            DB::table(Booking::TABLE_NAME)->insert($booking);
        }
    }
}
