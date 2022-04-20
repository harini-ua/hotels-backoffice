<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Use this helper when you need to quickly debug a request
     *
     * @example $this->bedugRequest($request, UpdateRequest::class)
     *
     * @param Request $request
     * @param string $requestClass
     */
    public function bedugRequest($request, $requestClass)
    {
        $validated = Validator::make($request->all(), (new $requestClass())->rules());
        dump($validated->errors());
        dump($request->all());
        die('dump');
    }
}
