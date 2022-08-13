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

        $data = (new BookingReceiptTransformer)->transform($booking);

        dd($data);

        return view('admin.print.receipt', compact('booking', 'data'));
        // https://ho.hotel-express.com/admin/index.php/admin/receipt_print/2347551
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
        // https://ho.hotel-express.com/admin/index.php/admin/voucher_print/2347551
    }
}
