<?php

namespace App\Transformers;

use App\Models\Booking;
use League\Fractal\TransformerAbstract;

class BookingReceiptTransformer extends TransformerAbstract
{
    /**
     * @param Booking $booking
     * @return array
     */
    public function transform(Booking $booking)
    {
        $booking->with(['guests']);

        return [
            'id' => (int) $booking->id,
        ];
    }
}
