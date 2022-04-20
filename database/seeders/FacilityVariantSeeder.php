<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilityVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $facility = [];
        $facility['ac'] = ['ac', 'air-conditioned', 'Air conditioning',
            'Air condition', 'air conditioned', 'Individual air-conditioned',
            'Central air-conditioned', 'Air Conditioning - some Rooms',
            'Air-conditioned in common areas', 'Individually adjustable air conditioning',
            'Air conditioning in public areas', 'airConditioning', 'Air Conditioned (public areas)',
            'Public area air conditioned', 'Room air filtration'];
        $facility['room_tv'] = ['TV', 'Television Regular', 'Television Cable/Satellite',
            'Television Regular', 'Television Cable', 'Television Pay Movies', 'Television - on request',
            'Satellite / cable TV', 'TV Lounge', 'Cable TV', 'television'];
        $facility['bathroom'] = ['Bathroom', 'Bathroom with shower', 'Bathroom with bath', 'Bathtub',
            'Private bath or shower', 'Steam bath'];
        $facility['shower'] = ['Shower'];
        $facility['hairdryer'] = ['Hairdryer', 'Hair dryer'];
        $facility['room_phone'] = ['Telephone', 'Telephone (some rooms)', 'Direct dial phone',
            'Mobile phone coverage', 'Phone services', 'Cell phone rental', 'Direct dial telephone',
            'Multiple phone lines billed separately'];
        $facility['internet'] = ['Internet access', 'Internet', 'Internet corner', 'Internet via television',
            'Public Internet', 'Wired Internet', 'Free high speed internet connection', 'Guestroom wired internet',
            'Guestroom wireless internet', 'High speed internet access', 'High speed internet access for laptop in public areas',
            'High speed wireless', 'Internet browser On TV', 'Internet services', 'Wireless internet connection in public areas'];
        $facility['bar'] = ['Minibar', 'bar', 'Mini bar', 'Bar(s)', 'Bars - 2', 'Bars - 1',
            'Bars - 3', 'Minibar - some rooms', 'Bars - 4', 'Bars - 5+', 'Lobby bar', 'Minibar on request',
            'Minibar (Superior Room Only)', 'Piano Bar', 'Terrace Bar', 'Garden Bar',
            'Small sized lobby', 'Bar/Snack/Café', 'Alcoholic beverages', 'Beach bar', 'Beer garden',
            'Beverage/cocktail', 'Cafe bar', 'Cocktail lounge', 'Cocktail lounge with entertainment',
            'Cocktail lounge with light fare', 'Communal bar area', 'Complimentary cocktails', 'Garden lounge bar',
            'Lounges/bars', 'Outdoor summer bar/cafe', 'Snack bar', 'Tapas bar', 'Sports bar'];
        $facility['tea_coffee'] = ['Tea/Coffee Making Facilities', 'Tea / Coffee', 'Café',
            'Tea and coffee making facilities', 'coffeeShop', 'Bar/Snack/Café', 'Complimentary in-room coffee or tea',
            '24-hour coffee shop', '24-hour food & beverage kiosk', 'Cafe bar', 'Coffee lounge', 'Coffee shop',
            'Coffee/tea', 'Complimentary coffee in lobby', 'Lobby coffee service'];
        $facility['elevators'] = ['Elevators -1', 'Elevators -2', 'Elevators -3', 'Elevator',
            'elevators', 'Brailed elevators'];
        $facility['laptop'] = ['Connection for laptop'];
        $facility['voltage'] = ['Voltage 2', '120 AC', '120 DC', '220 AC', '220 DC', 'Desk with electrical outlet'];
        $facility['safebox'] = ['SafeDeposit', 'Safe in reception', 'Safe box at reception', 'Hotel safe',
            'Secretarial service', 'Safe deposit box', 'Storage space', 'Storage space available - fee'];
        $facility['roomservice'] = ['RoomService', 'Room Service', 'Partial Room Service', 'Room service 24 hour',
            'Room Service - 24 hour', '24-hour front desk', '24-hour room service', '24-hour security', 'Airline desk',
            'Complimentary self service laundry', 'Laundry/Valet service', 'Limited service housekeeping',
            'Limousine service', 'Room service - full menu', 'Room service - limited hours',
            'Room service - limited menu', 'Room upgrade confirmed', 'Room upgrade on availability', 'Security',
            'Semi-private space', 'Shuttle to local businesses', 'Valet cleaning', 'Valet same day dry cleaning',
            'VIP security', 'Wakeup service', 'Water purification system in use', 'Wedding services', 'Housekeeping - daily'];
        $facility['businessfacilities'] = ['BusinessFacilities', 'Business Centre (Chargeable)',
            'Conference Facilities', 'Business centre', 'Meeting room', 'Conference room', 'Meeting rooms',
            'Business center', 'Business library', 'Business services', 'Conference facilities', 'Secretarial service'];
        $facility['concierge'] = ['Concierge', 'Concierge desk', 'Concierge floor', 'Concierge lounge',
            'Technical concierge'];
        $facility['petallowed'] = ['PetsAllowed', 'Pets allowed', 'Pets allowed for a fee per night',
            'YES Large pets allowed (over 5 kg)', 'YES Small pets allowed (under 5 kg)', 'Pet amenities available',
            'Pet-sitting services'];
        $facility['porterage'] = ['Porterage'];
        $facility['pool'] = ['SwimmingPool', '2 outdoor pools', 'pool', 'Swimming Pool', 'Swimming Pool - outdoor',
            'Swimming Pool Heated Indoor', 'Outdoor Swimming pool', 'Fresh water pool', 'Outdoor pool',
            'Heated pool', 'outdoor pools', 'Spa Pool', 'Swimming Pool Heated Outdoor', 'Swimming Pool (Summer Only)',
            'Swimming Pool (Chargeable)', 'Swimming Pool - indoor', '1 outdoor pool', '1 indoor pool',
            '1 outdoor pool (heated)', 'Indoor pool', 'Indoor heated pool', 'Indoor Swimming pool',
            'Outdoor freshwater pool', 'Indoor freshwater pool', '3 outdoor pools', '1 indoor pool (heated)',
            '4 outdoor pools', '2 outdoor pools (heated)', '7 outdoor pools (heated)', 'Indoor pool',
            'Poolside service', 'Poolside snack bar', 'Private pool'];
        $facility['restaurant'] = ['restaurant', 'Restaurant(s)', 'Restaurant – 1',
            'Restaurants - 2', 'Restaurants - 3', 'Restaurants - 4', 'Air Conditioning in Restaurant',
            'Restaurant (Closed Weekends)', 'Cafe/Restaurant', 'Restaurants - 5', 'Restaurants - 8', 'Restaurants - 6',
            'Dinner delivery service from local restaurant', 'Dinner served in restaurant',
            'Lunch served in restaurant'];
        $facility['sauna'] = ['Sauna'];
        $facility['gym'] = ['Gym', 'Gym/Fitness Facility', 'Gym (Chargeable)', 'Gym (nearby)', 'Gymnasium', 'Exercise gym',
            'Fitness center', 'Sports bar', 'Sports bar open for dinner', 'Sports bar open for lunch', 'Sports trainer'];
        $facility['wheelchair'] = ['Wheelchair accessible', 'Disabled Facilities',
            'Disabled bathroom', 'Disabled Facilities in Public Areas', 'Disabled Facilities in Rooms',
            'Disabled Facilities in some Rooms', 'Disabled Access', 'Disabled Facilities are Limited',
            'YES Wheelchair-accessible', 'Access for Disabled', 'Disability-friendly rooms', 'Wheelchair access'];
        $facility['fax'] = ['Fax', 'Fax service', 'Incoming fax', 'Outgoing fax'];
        $facility['centralheating'] = ['Central heating', 'Heating', 'Individually adjustable heating'];
        $facility['bellboy'] = ['Bell boy', 'Bell staff/porter', 'Luggage service'];
        $facility['wifi'] = ['Wi-Fi', 'Wi-Fi (public areas)', 'Wi-Fi access in rooms (complimentary)',
            'Wi-Fi access in public areas (complimentary)', 'Free Wi-Fi (public areas)', 'Complimentary wireless internet'];
        $facility['breakfast_included'] = ['breakfast_included', 'Buffet Breakfast', 'Breakfast room',
            'Breakfast served in room', 'Continental breakfast', 'Breakfast served in restaurant',
            'Carryout breakfast', 'Children\'s breakfast', 'Complimentary breakfast', 'Complimentary buffet breakfast',
            'Complimentary continental breakfast', 'Complimentary full american breakfast', 'Concierge breakfast',
            'Deluxe continental breakfast', 'Full american breakfast', 'Full meal plan', 'Hot breakfast',
            'continental breakfast'];
        $facility['satellite_tv'] = ['Satellite television', 'Satellite / cable TV', 'TV Salón',
            'Television Satellite', 'Television Cable/Satellite', 'Satellite TV', 'TV'];
        $facility['parking'] = ['parking', 'Parking - nearby', 'Parking - onsite', 'Car Parking',
            'Car Parking (Chargeable)', 'Coach Parking', 'Car Parking (limited spaces)', 'Coach Parking (Chargeable)',
            'Car Parking Nearby', 'Coach parking nearby', 'Valet Parking',
            'Car parking (Payable to hotel, if applicable)', 'Car park', 'YES Car park',
            'Secure parking', 'Outdoor Parking', 'Pay Parking', 'Free Parking', 'Bus parking', 'Indoor parking',
            'Limited parking', 'Long term parking', 'Motorcycle parking', 'Off-Site parking',
            'Parking - controlled access gates to enter parking area',  'Parking - controlled access gates to enter parking area',
            'Parking deck', 'Parking fee managed by hotel', 'Parking lot', 'Recreational vehicle parking',
            'Secured parking', 'Street side parking', 'Truck parking', 'Free parking'];
        $facility['non_smoking_rooms'] = ['non_smoking_rooms', 'No Smoking in the hotel', 'Non Smoking facilities',
            'No Smoking in the hotel', 'NO Smoking rooms', 'Non-smoking area', 'All public areas non-smoking',
            'Non-smoking rooms (generic)'];
        $facility['tennis'] = ['tennis', 'Tennis Courts', 'Tennis Court (equipment charge only)', 'Tennis court'];
        $facility['garden'] = ['garden', 'Garden Terrace', 'Garden Residents Only', 'Garden lounge bar'];
        $facility['golf'] = ['golf', 'Golf course', 'Golf course nearby', 'Golf Course (Chargeable)', 'Mini-Golf'];
        $facility['carcharging'] = ['Electrical car charging for free', 'Electric car charging against payment',
            'Electric car charging stations'];
        $facility['spa'] = ['spa', 'Spa centre', 'Spa treatments', 'Spa Facilities (complimentary)',
            'Health Spa (Complimentary)', 'Health Spa (Chargeable)', 'Spa Facilities (Chargeable)', 'Hotels with spa'];
        $facility['professional_staff'] = ['Multilingual staff'];
        $facility['smoke_free'] = ['Smoke-free property'];
        $facility['roof_terrace'] = ['Roof terrace'];
        $facility['complimentary_newspaper'] = ['Complimentary newspaper in lobby', 'Complimentary newspaper delivered to room'];
        $facility['tour_desk'] = ['Tour/sightseeing desk'];

        $facilities = [];
        foreach ($facility as $facility_name => $variants) {
            foreach ($variants as $variant) {
                $facility_id = DB::table('facilities')->select('id')->where('name', $facility_name)->first();
                $facilities[] = [
                    'facility_id' => $facility_id->id,
                    'name' => strtolower($variant),
                ];
            }
        }

        DB::table('facility_variants')->insertTs($facilities);
    }
}
