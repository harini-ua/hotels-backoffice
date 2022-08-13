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

class BookingReceiptTransformer extends TransformerAbstract
{
    /**
     * @param Booking $booking
     * @return array
     */
    public function transform(Booking $booking)
    {
        $booking->with([
            'provider',
            'hotel',
            'bookingUser.company.supports',
            'company.homepageOption s',
            'company.supports',
            'guests',
        ]);

        if ($booking->provider->name === 'grn') {
            $result['booking_number'] = $booking->booking_reference;
        } elseif ($booking->inn_off_code) {
            $result['booking_number'] = $booking->inn_off_code .'-'. $booking->booking_reference;
        } elseif ($booking->provider->name === 'miki') {
            $result['booking_number'] = $booking->booking_reference .' - '. $booking->additional_booking_reference;
        } else {
            $result['booking_number'] = $booking->booking_reference;
        }

        $result['country_name'] = $booking->bookingUser->country->name;
        $result['booking_email'] = $booking->guests[0]->email;
        $result['booking_checkin'] = Formatter::date($booking->checkin, 'M d, Y');
        $result['booking_checkout'] = Formatter::date($booking->checkout, 'M d, Y');
//        $result['cancellation_key'] = $booking->cancellation_key;

        $result['hotel_name'] = $booking->hotel->name;
        $result['hotel_address'] = rtrim($booking->hotel->address, '<br>');
        $result['room_type'] = explode('-', $booking->room_type);
        $result['rooms'] = $booking->rooms;
        $result['adults'] = $booking->adults;
        $result['children'] = $booking->children;

        $result['package_enabled'] = false;
        if ($booking->company->mainOptions) {
            $result['package_enabled'] = $booking->company->mainOptions->allow_package;
        }

        $result['extra_nights'] = $booking->extra_nights;
        if ($booking->extra_nights) {
            $partnerNights = $booking->company->partnerProduct->nights;
            $customer_price = $booking->company->extraNights->customer_price;

            $result['extra_nights_amount'] = ($booking->nights - $partnerNights) * $customer_price;
            $result['extra_nights_amount'] = number_format(
                (float) $result['extra_nights_amount'], 2, ".", ""
            );
            $result['extra_nights_currency'] = $booking->company->extraNights->currency->code;
        }

        if ($result['package_enabled']) {
            $amount = ($booking->amount > $booking->final_amount) ? $booking->amount : $booking->final_amount;
            if (in_array($booking->selected_currency->code, config('general.currency_array'))) {
                $amount *= $booking->conversion_rate;
            }

            $extraNightsAmount = ($booking->nights - $booking->company->partnerProduct->nights) * $booking->company->extraNights->customer_price;
            $result['amount'] = $booking->extra_nights ? $extraNightsAmount : $amount;
            if ($booking->extra_nights) {
                $result['currency'] = $booking->company->extraNights->currency->code;
            } else {
                $result['currency'] = $booking->original_currency->code;
                if ($booking->selected_currency_id) {
                    $result['currency'] = $booking->selected_currency->code;
                }
            }
        }

        $result['user_language_id'] = Auth::user()->language_id ?? config('admin.language.default.id');
        $result['customer_support'] = $this->getCustomerSupport($booking);
        $result['provider_name'] = $booking->provider->name;
        $result['mobile_flag'] = $booking->mail_flag;

        $result['show_all_booking_non_refund'] = $booking->company->template
            ? $booking->company->template->show_all_booking_non_refund : 0;

        foreach ($booking->guests as $guest) {
            $result['guests'][] = $guest->fullname;
        }

        $result['voucher_date'] = Formatter::date($booking->created_at, 'M d, Y');
        $result['logo'] = asset('storage/companies/'.$booking->company->id.'/'.$booking->company->homepageOptions->logo);
        $result['copyright'] = '© 1987 - ' .Carbon::now()->format('Y');
        $result['translation'] = $this->getPageField(121, (int) $result['user_language_id']);

        return $result;
    }

    /**
     * Get customer support
     *
     * @param Booking $booking
     * @return array|null
     */
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

        if (! $support) {
            return null;
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

        return $query->pluck('name', 'field_id')->toArray();
    }
}
