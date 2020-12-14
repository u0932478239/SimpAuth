<?php

function php_compat_str_split($string, $split_length = 1)
{
    if (!is_scalar($split_length)) {
        user_error('str_split() expects parameter 2 to be long, ' .
            gettype($split_length) . ' given', E_USER_WARNING);
        return false;
    }

    $split_length = (int) $split_length;
    if ($split_length < 1) {
        user_error('str_split() The length of each segment must be greater than zero', E_USER_WARNING);
        return false;
    }
    
    // Select split method
    if ($split_length < 65536) {
        // Faster, but only works for less than 2^16
        preg_match_all('/.{1,' . $split_length . '}/s', $string, $matches);
        return $matches[0];
    } else {
        // Required due to preg limitations
        $arr = array();
        $idx = 0;
        $pos = 0;
        $len = strlen($string);

        while ($len > 0) {
            $blk = ($len < $split_length) ? $len : $split_length;
            $arr[$idx++] = substr($string, $pos, $blk);
            $pos += $blk;
            $len -= $blk;
        }

        return $arr;
    }
}


if (!function_exists('str_split')) {
    function str_split($string, $split_length = 1)
    {
        return php_compat_str_split($string, $split_length);
    }
}
