<?php

if (!function_exists('generateDiscountCodes')) {
    function generateDiscountCodes($length = 11)
    {
        return substr(md5(\Carbon\Carbon::now()->timestamp . randomStrings(10)), 0, $length);
    }
}

if (!function_exists('randomStrings')) {
    function randomStrings($length = 32)
    {
        $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

        return substr(str_shuffle($str_result), 0, $length);
    }
}
