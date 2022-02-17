<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProviderEnvironmentSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provider_environment')->insert(
            [
                [
                    'provider_id' => 1,
                    'environment_id' => 1,
                    'username' => '',
                    'password' => '',
                    'status' => 0,
                    'timeout' => 10,
                    'api_key' => '6wq5fdbp8qq8pndz8ngpdetn',
                    'api_secret' => 'nfZKdrxBs6',
                    'client_agent_id' => '',
                    'affiliation' => '',
                    'user_code' => '',
                    'main_endpoint' => '',
                    'search_endpoint' => 'https://api.test.hotelbeds.com/hotel-api/1.0/hotels',
                    'recheck_endpoint' => 'https://api.test.hotelbeds.com/hotel-api/1.0/checkrates',
                    'pre_reservation_endpoint' => '',
                    'booking_endpoint' => 'https://api.test.hotelbeds.com/hotel-api/1.0/bookings',
                    'location_countries_endpoint' => 'https://api.test.hotelbeds.com/hotel-content-api/1.0/locations/countries',
                    'rate_comments_endpoint' => 'https://api.test.hotelbeds.com/hotel-content-api/1.0/types/ratecommentdetails'
                ],
                [
                    'provider_id' => 1,
                    'environment_id' => 2,
                    'username' => '',
                    'password' => '',
                    'status' => 1,
                    'timeout' => 10,
                    'api_key' => 'e014e8b8fbb5528599f6c39732a07519',
                    'api_secret' => '68c9637df4',
                    'client_agent_id' => '',
                    'affiliation' => '',
                    'user_code' => '',
                    'main_endpoint' => '',
                    'search_endpoint' => 'https://api.hotelbeds.com/hotel-api/1.0/hotels',
                    'recheck_endpoint' => 'https://api.hotelbeds.com/hotel-api/1.0/checkrates',
                    'pre_reservation_endpoint' => '',
                    'booking_endpoint' => 'https://api.hotelbeds.com/hotel-api/1.0/bookings',
                    'location_countries_endpoint' => 'https://api.hotelbeds.com/hotel-content-api/1.0/locations/countries',
                    'rate_comments_endpoint' => 'https://api.hotelbeds.com/hotel-content-api/1.0/types/ratecommentdetails'
                ],
                [
                    'provider_id' => 2,
                    'environment_id' => 2,
                    'status' => 1,
                    'username' => 'HotelExpress',
                    'password' => '2YntZtGX6j',
                    'timeout' => 80,
                    'api_key' => '',
                    'api_secret' => '',
                    'client_agent_id' => '',
                    'affiliation' => '',
                    'user_code' => '',
                    'search_endpoint' => '',
                    'recheck_endpoint' => '',
                    'pre_reservation_endpoint' => '',
                    'booking_endpoint' => '',
                    'location_countries_endpoint' => '',
                    'rate_comments_endpoint' => '',
                    'main_endpoint' => 'http://clientapi.jactravel.com/xml/book.aspx'
                ],
                [
                    'provider_id' => 3,
                    'environment_id' => 2,
                    'status' => 1,
                    'username' => 'hoss',
                    'password' => 'xml447164',
                    'api_key' => '',
                    'api_secret' => '',
                    'timeout' => 60,
                    'client_agent_id' => '62888',
                    'affiliation' => 'RS',
                    'user_code' => 'B40580',
                    'search_endpoint' => '',
                    'recheck_endpoint' => '',
                    'pre_reservation_endpoint' => '',
                    'booking_endpoint' => '',
                    'location_countries_endpoint' => '',
                    'rate_comments_endpoint' => '',
                    'main_endpoint' => 'https://xml.hotelresb2b.com/xml/listen_xml.jsp'
                ],
                [
                    'provider_id' => 4,
                    'environment_id' => 2,
                    'status' => 0,
                    'username' => '',
                    'password' => '@5XPR5SS',
                    'api_key' => '',
                    'api_secret' => '',
                    'timeout' => 10,
                    'client_agent_id' => '33546',
                    'affiliation' => '',
                    'user_code' => '',
                    'search_endpoint' => '',
                    'recheck_endpoint' => '',
                    'pre_reservation_endpoint' => '',
                    'booking_endpoint' => '',
                    'location_countries_endpoint' => '',
                    'rate_comments_endpoint' => '',
                    'main_endpoint' => 'https://origin-rs.gta-travel.com/wbsapi/RequestListenerServlet'
                ],
                [
                    'provider_id' => 6,
                    'environment_id' => 2,
                    'status' => 1,
                    'api_key' => '',
                    'api_secret' => '',
                    'username' => 'hoss',
                    'password' => '42S99L04F68X02V20G85',
                    'timeout' => 20,
                    'client_agent_id' => 'HOX001',
                    'affiliation' => '',
                    'user_code' => '',
                    'search_endpoint' => '',
                    'recheck_endpoint' => '',
                    'pre_reservation_endpoint' => '',
                    'booking_endpoint' => '',
                    'location_countries_endpoint' => '',
                    'rate_comments_endpoint' => '',
                    'main_endpoint' => 'https://www.miki.co.uk/mInt/XMLRequest?xml='
                ],
                [
                    'provider_id' => 7,
                    'environment_id' => 2,
                    'status' => 1,
                    'username' => '',
                    'api_key' => '',
                    'api_secret' => '',
                    'password' => '070818XMTV',
                    'timeout' => 10,
                    'client_agent_id' => '147MTV',
                    'affiliation' => '',
                    'user_code' => '',
                    'recheck_endpoint' => '',
                    'pre_reservation_endpoint' => '',
                    'booking_endpoint' => '',
                    'location_countries_endpoint' => '',
                    'main_endpoint' => 'http://xmlv7.travco.co.uk/trlink/link1/trlink',
                    'rate_comments_endpoint' => '',
                    'search_endpoint' => 'http://xmlv6.travco.co.uk/trlink/schema/HotelAvailabilityV6Snd.xsd',
                ],
                [
                    'provider_id' => 9,
                    'environment_id' => 1,
                    'status' => 0,
                    'username' => '',
                    'password' => '',
                    'timeout' => 10,
                    'api_key' => '1ff901ef58fc73c15c9a10464980451c',
                    'api_secret' => '',
                    'client_agent_id' => '',
                    'affiliation' => '',
                    'user_code' => '',
                    'search_endpoint' => 'https://api-sandbox.grnconnect.com/api/v3/hotels/availability',
                    'recheck_endpoint' => '/rates/?action=recheck',
                    'booking_endpoint' => 'https://api-sandbox.grnconnect.com/api/v3/hotels/bookings',
                    'pre_reservation_endpoint' => '',
                    'location_countries_endpoint' => '',
                    'main_endpoint' => '',
                    'rate_comments_endpoint' => '',
                ],
                [
                    'provider_id' => 9,
                    'environment_id' => 2,
                    'status' => 1,
                    'username' => '',
                    'password' => '',
                    'timeout' => 10,
                    'api_key' => '73e197160391d5cbf1cccf203662a359',
                    'api_secret' => '',
                    'client_agent_id' => '',
                    'affiliation' => '',
                    'user_code' => '',
                    'search_endpoint' => 'https://v4-api.grnconnect.com/api/v3/hotels/availability',
                    'recheck_endpoint' => '/rates/?action=recheck',
                    'booking_endpoint' => 'https://v4-api.grnconnect.com/api/v3/hotels/bookings',
                    'pre_reservation_endpoint' => '',
                    'location_countries_endpoint' => '',
                    'main_endpoint' => '',
                    'rate_comments_endpoint' => '',
                ]
            ]
        );
    }
}