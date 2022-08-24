<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Transformers\BookingReceiptTransformer;
use App\Transformers\BookingVoucherTransformer;
use Illuminate\Http\Response;
use Illuminate\View\View;

class PrintController extends Controller
{
    /**
     * @param int $id
     * @return Response|View
     */
    public function receipt($id)
    {
        $booking = Booking::findOrFail($id);

        $data = (new BookingReceiptTransformer)->transform($booking);

        return view('admin.print.receipt', compact('booking', 'data'));
    }

    /**
     * @param int $id
     * @return Response|View
     */
    public function voucher($id)
    {
        $booking = Booking::findOrFail($id);

        $data = (new BookingVoucherTransformer)->transform($booking);

        return view('admin.print.voucher', compact('booking', 'data'));
    }
}
