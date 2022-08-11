<?php

namespace App\Transformers;

use App\Models\Booking;
use App\Models\PageField;
use App\Models\PageFieldTranstation;
use App\Services\Formatter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Fractal\TransformerAbstract;

class BookingVoucherTransformer extends TransformerAbstract
{
    /**
     * @param Booking $booking
     * @return array
     */
    public function transform(Booking $booking)
    {
        // Load relationships
        $booking->with([
            'provider',
            'hotel',
            'bookingUser.company.supports',
            'company.homepageOptions',
            'company.supports',
            'guests',
        ]);

        // Build final data result
        if ($booking->provider->name === 'grn') {
            $result['booking_number'] = $booking->id;
        } elseif ($booking->inn_off_code) {
            $result['booking_number'] = $booking->inn_off_code .'-'. $booking->id;
        } elseif ($booking->provider->name === 'miki') {
            $result['booking_number'] = $booking->id .' - '. $booking->additional_booking_reference;
        } else {
            $result['booking_number'] = $booking->id;
        }

        $result['booking_username'] = $booking->guests[0]->fullname;
        $result['booking_email'] = $booking->guests[0]->email;
        $result['booking_checkin'] = Formatter::date($booking->checkin, 'M d, Y');
        $result['booking_checkout'] = Formatter::date($booking->checkout, 'M d, Y');

        foreach ($booking->guests as $guest) {
            $result['guests'][] = $guest->fullname;
        }

        $result['supplier_name'] = $booking->supplier_name;
        $result['vat_number'] = $booking->vat_number;

        // TODO: $booking->contract_remark ?
        if ($booking->contract_remark) {
            $textToBeRemoved = "Please note that once the client has checked in and in the event of an unanticipated " .
                "departure, the hotel may invoice the total amount of the reservation. In the event of a no-show, the " .
                "hotel is also authorized to invoice the total amount of the reservation.";
            $remark = str_replace($textToBeRemoved, '', trim($booking->contract_remark));
            $result['contract_remark'] = iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $remark);
        }

        $result['rooms'] = $booking->rooms;
        $result['adults'] = $booking->adults;
        $result['children'] = $booking->children;

        foreach ($booking->guests as $guest) {
            if ($guest->child_age) {
                $result['children_ages'][] = $guest->child_age;
            }
        }

        $result['mobile_flag'] = $booking->mail_flag;
        $result['hotel_name'] = $booking->hotel->name;
        $result['hotel_address'] = $booking->hotel->address;
        $result['room_type'] = explode('-', $booking->room_type);
        $result['customer_support'] = $this->getCustomerSupport($booking);
        $result['provider_name'] = $booking->provider->name;
        $result['provider_support_phone'] = $booking->provider->support_phone;
        $result['user_language_id'] = Auth::user()->language_id ?? config('admin.language.default.id');
        $result['voucher_date'] = Formatter::date($booking->created_at, 'M d, Y');
        $result['logo'] = asset('storage/companies/'.$booking->company->id.'/'.$booking->company->homepageOptions->logo);
        $result['copyright'] = '© 1987 - ' .Carbon::now()->format('Y');
        $result['translation'] = $this->getPageField(121, (int) $result['user_language_id']);

        return $result;
    }

    protected function getCustomerSupport(Booking $booking)
    {
        $support = $booking->bookingUser->company->supports()
            ->where('country_id', $booking->country_id)->first();

        if (! $support) {
            $support = $booking->company->supports()->first();

            if (! $support) {
                $support = $booking->bookingUser->company->supports()
                    ->whereNull('country_id')->first();
            }
        }

        return [
            'phone' => $support->phone,
            'work_hours' => $support->work_hours,
            'email' => $support->email,
            'country' => $support->country_id ? $support->country->name : __('International'),
        ];
    }

    /**
     * Get page foelds
     *
     * @param integer $pageId
     * @param integer $languageId
     * @return array
     */
    protected function getPageField($pageId, $languageId)
    {
        $query = PageField::select([
            'page_fields.id AS field_id',
            'page_fields.page_id AS page_id',
            'page_fields.name',
            'translation.value AS translation',
            'page_fields.is_mobile AS group',
            'page_fields.type AS type',
            'page_fields.max_length AS max_length',
        ]);

        $query->selectRaw($languageId.' AS language_id');

        $translation = DB::table(PageFieldTranstation::TABLE_NAME)
            ->select([
                'page_id',
                'field_id',
                'language_id',
                DB::raw('translation AS value'),
            ])
            ->where('page_id', $pageId)
            ->where('language_id', $languageId);

        $query->leftJoinSub($translation, 'translation', static function($join) {
            $join->on('page_fields.id', '=', 'translation.field_id');
        });

        $query->where('page_fields.page_id', $pageId);

        return $query->pluck('translation', 'name')->toArray();
    }
}
