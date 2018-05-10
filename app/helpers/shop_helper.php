<?php defined('BASEPATH') OR exit('No direct script access allowed');

if(! function_exists('convert_currency')) {
    function convert_currency($amount, $from, $to) {
        $data = file_get_contents("https://www.google.com/finance/converter?a=$amount&from=$from&to=$to");
        preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
        $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        return number_format(round($converted, 3), 2);
    }
}
