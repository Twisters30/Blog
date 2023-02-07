<?php

function dd($die = false, ...$data)
{
    echo '<pre>' . print_r($data, 1);
    $backtrace = debug_backtrace();
    echo var_dump('FILE :'.$backtrace[0]['file']);
    echo var_dump('LINE :'.$backtrace[0]['line']);

    if ($die) {
        die;
    }
}