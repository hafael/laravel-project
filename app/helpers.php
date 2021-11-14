<?php

if (! function_exists('dec2cts')) {
    function dec2cts($value, $decimals = 0) {

        if(is_string(($value))){
            dd($value, $decimals);
        }
        return (int) (string) ((float) preg_replace("/[^0-9.]/", "", number_format($value, $decimals)) * intval(str_pad('1', $decimals + 1, '0')));
    }
}

if (! function_exists('cts2dec')) {
    function cts2dec($value, $decimals = 0) {

        $total = floatval(strval(floatval(
            preg_replace("/[^0-9.]/", "", $value)
        ) / intval(str_pad('1', $decimals + 1, '0'))));

        return number_format($total, $decimals, '.', '');
    }
}

if (! function_exists('bcmul2int')) {
    function bcmul2int($value, $decimals = 0) {
        return (int) bcmul($value, (int) str_pad('1', $decimals + 1, '0'));
    }
}

if (! function_exists('only_numbers')) {
    function only_numbers($value) {
        return preg_replace("/[^0-9]/", "", $value);
    }
}

if (! function_exists('is_posint')) {
    function is_posint($value) {
        return (int) $value == $value && (int) $value > 0;
    }
}