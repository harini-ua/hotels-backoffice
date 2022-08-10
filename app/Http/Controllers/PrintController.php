<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Transformers\BookingReceiptTransformer;
use App\Transformers\BookingVoucherTransformer;
use Illuminate\Http\Response;
use Illuminate\View\View;
use League\Fractal\Resource\Item;

class PrintController extends Controller
{
    /**
     * @param int $id
     * @return Response|View
     */
    public function receipt($id)
    {
        $booking = Booking::findOrFail($id);

        $resource = new Item($booking, new BookingReceiptTransformer);

        return view('admin.print.receipt', compact('booking', 'resource'));
    }

    /**
     * @param int $id
     * @return Response|View
     */
    public function voucher($id)
    {
        $booking = Booking::findOrFail($id);

        $resource = new Item($booking, new BookingVoucherTransformer);

        return view('admin.print.voucher', compact('booking', 'resource'));
    }
}
