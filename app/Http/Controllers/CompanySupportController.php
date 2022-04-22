<?php

namespace App\Http\Controllers;

use App\Models\CompanySupport;
use Illuminate\Http\JsonResponse;

class CompanySupportController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param CompanySupport $support
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(CompanySupport $support)
    {
        if ($support->delete()) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
