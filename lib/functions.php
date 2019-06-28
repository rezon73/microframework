<?php

if (!function_exists('mb_str_split')) {
    function mb_str_split($str, $split_length) {
        $chars = array();
        $len = mb_strlen($str, 'UTF-8');
        for ($i = 0; $i < $len; $i+=$split_length ) {
            $chars[] = mb_substr($str, $i, $split_length, 'UTF-8');
        }

        return $chars;
    }
}