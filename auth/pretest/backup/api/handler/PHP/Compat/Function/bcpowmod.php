<?php

function php_compat_bcpowmod($x, $y, $modulus, $scale = 0)
{
    // Sanity check
    if (!is_scalar($x)) {
        user_error('bcpowmod() expects parameter 1 to be string, ' .
            gettype($x) . ' given', E_USER_WARNING);
        return false;
    }

    if (!is_scalar($y)) {
        user_error('bcpowmod() expects parameter 2 to be string, ' .
            gettype($y) . ' given', E_USER_WARNING);
        return false;
    }

    if (!is_scalar($modulus)) {
        user_error('bcpowmod() expects parameter 3 to be string, ' .
            gettype($modulus) . ' given', E_USER_WARNING);
        return false;
    }

    if (!is_scalar($scale)) {
        user_error('bcpowmod() expects parameter 4 to be integer, ' .
            gettype($scale) . ' given', E_USER_WARNING);
        return false;
    }

    $t = '1';
    while (bccomp($y, '0')) {
        if (bccomp(bcmod($y, '2'), '0')) {
            $t = bcmod(bcmul($t, $x), $modulus);
            $y = bcsub($y, '1');
        }

        $x = bcmod(bcmul($x, $x), $modulus);
        $y = bcdiv($y, '2');
    }

    return $t;    
}


// Define
if (!function_exists('bcpowmod')) {
    function bcpowmod($x, $y, $modulus, $scale = 0)
    {
        return php_compat_bcpowmod($x, $y, $modulus, $scale);
    }
}