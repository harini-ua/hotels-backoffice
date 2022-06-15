<?php

namespace App\Http\Controllers;

use App\Models\Booking;
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

        // TODO: Need Implement

        return view('admin.print.receipt', compact('booking'));
    }

    /**
     * @param int $id
     * @return Response|View
     */
    public function voucher($id)
    {
        $booking = Booking::findOrFail($id);

        // TODO: Need Implement

        return view('admin.print.voucher', compact('booking'));
    }
}
