<?php

namespace App\Http\Controllers;

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
        // TODO: Need Implement

        return view('admin.print.receipt');
    }

    /**
     * @param int $id
     * @return Response|View
     */
    public function voucher($id)
    {
        // TODO: Need Implement

        return view('admin.print.voucher');
    }
}
