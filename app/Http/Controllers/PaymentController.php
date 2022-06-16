<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    /**
     * Payment booking
     *
     * @param int $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function booking($id)
    {
        $booking = Booking::findOrFaill($id);

        // TODO: Implement payment booking

        if (true) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
