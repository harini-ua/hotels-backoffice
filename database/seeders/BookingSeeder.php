<?php

namespace Database\Seeders;

use App\Models\DiscountVoucherCode;
use App\Models\Hotel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//for bookings.csv
//SELECT b.booking_no, a.api_id, b.voucher_date, b.booking_ref_no, b.booking_reference_cancel_grn, b.full_discount, b.status,
//b.itemcode, b.check_in, b.check_out, b.hei_hotel_code, b.room_type, b.roomNumber, b.nights, b.trans_cancellation_date,
//b.trans_cancellation_time, b.cancellation_policy, b.refundablestatus, b.euserid, b.inoffcode, b.adult_count, b.child_count,
//b.remark, b.customer_name, b.customer_email, b.phone, b.amount, b.bookingcommission, b.final_amount, c.id as currency_id,
//b.conv_rate_payment_to_user_prices, d.id as discount_voucher_code_id, b.hotelbed_rate_key, b.payment_reference, b.cancelled_date
//FROM customer_booking b
//LEFT JOIN tblcurrencyname c ON c.currencyname = b.selectedcurrency
//LEFT JOIN discount_codes d ON d.code = b.discount_code
//LEFT JOIN api_control a ON a.api_name = b.api
//WHERE a.api_id IS NOT NULL AND b.euserid IN(413,414,415,417,419,420,421,426,439,440,441,442,443,444,448,450,456,457,469,474,496,514,531,582,583,584,595,598,606,607,610,649,728,846,1413,1414,1415,1416,1417,
//1418,1425,1567,1647,1665,1716,2180,2181,2567,3278,3386,3514,3712,3851,4442,5955,6022,8321,8963,10735,11264,11654,17143,18250,19534,20760,21626,21627,21629,22252,22639,43215,44758,
//46906,49866,56297,62937,69120,76246,79846,79866,79871,80264,84098,84790,85033,86191,88897,95737,96661,105752,106065,600005870,600005871,600005875,600005876,600005877,
//600005878,600005879,600005880,600005903,600008316,600009655,600009658,600010762,600012849,600015667,600015932,600017421,600019033,600019231,600020647,600021665,
//600023392,600024749,600032297,600036688,600039605,600045873,600046760,600053428,600053487,600064311,600066380,600069547,600074864,600080065,600081104,600084312,
//600084313,600084315,600092227,600093592,600094840,600095569,600102896,600102900,600102989,600103502,600103729,600105276,600109136,600111782,600115113,600126230,600127008,600130797,600136958,60013838)
        $bookings = [];

        if (($open = fopen(storage_path('app/seed') . "/bookings.csv", "r")) !== false) {
            while (($data = fgetcsv($open, 0, ',')) !== false) {

                //remove this condition before full seeding Database
                if((Hotel::find((int)$data[10]) && !(int)$data[31]) || (Hotel::find((int)$data[10]) && ((int)$data[31] && DiscountVoucherCode::find((int)$data[31])))) {

                    preg_match_all('!\d+!', $data[16], $refundable);
                    $cancellation_date = NULL;
                    if((int)$data[14] && (int)$data[15]) {
                        $date = str_replace('/', '-', $data[14]);
                        $time = str_replace('AM', '', str_replace('PM', '', $data[15]));
                        $date = strstr($date, '-') ? $date : substr_replace(substr_replace($date, '-', 4, 0), '-', 7, 0);
                        $time = strstr($time, ':') ? $date : substr_replace($time, ':', 2, 0);
                        $cancellation_date = date('Y-m-d H:i:s', strtotime($date . ' ' . $time));
                    }

                    $bookings[] = [
                        'id' => (int)$data[0],
                        'provider_id' => (int)$data[1],
                        'booking_reference' => $data[3],
                        'booking_cancel_reference' => $data[4],
                        'payment_type' => (int)$data[5],
                        'status' => $data[6] == 'CONFIRMED' ? 1 : ($data[6] == 'Cancelled' ? 2 : ($data[6] == 'Paid, but not confirmed' ? 3 : ($data[6] == 'Not Paid' ? 4 : 0))),
                        'item_code' => $data[7],
                        'checkin' => date('Y-m-d', strtotime(str_replace('/', '-', $data[8]))),
                        'checkout' => date('Y-m-d', strtotime(str_replace('/', '-', $data[9]))),
                        'hotel_id' => (int)$data[10],
                        'room_type' => $data[11],
                        'rooms' => (int)$data[12],
                        'nights' => (int)$data[13],
                        'cancellation_date' => $cancellation_date,
                        'cancelled_date' => $data[34] == NULL ? NULL : date('Y-m-d', strtotime($data[34])),
                        'cancellation_policy' => $data[16],
                        'refundable_status' => empty($refundable[0]) ? 0 : 1,
                        'booking_user_id' => (int)$data[18],
                        'inn_off_code' => $data[19],
                        'adults' => (int)$data[20],
                        'children' => (int)$data[21],
                        'remarks' => $data[22],
                        'customer_name' => $data[23],
                        'customer_email' => $data[24],
                        'customer_phone' => $data[25],
                        'amount' => (float)$data[26],
                        'commission' => (float)$data[27],
                        'final_amount' => (float)$data[28],
                        'currency_id' => !(int)$data[29] ? 1 : (int)$data[29],
                        'conversion_rate' => (float)$data[30],
                        'discount_voucher_code_id' => !(int)$data[31] ? NULL : (int)$data[31],
                        'room_rate_key' => $data[32],
                        'payment_reference' => $data[33],
                        'created_at' => date('Y-m-d H:i:s', strtotime($data[2])),
                    ];
                }
            }

            fclose($open);
        }

        foreach (array_chunk($bookings, 1000) as $booking) {
            DB::table('bookings')->insertTs($booking);
        }
    }
}