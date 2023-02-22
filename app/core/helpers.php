<?php 

function config($key) : string|array
{
    static $config; // Cache config
    if (!$config) {
        $config = json_decode(file_get_contents(base_path('config.json')), true);
    }
    return $config[$key];
}


function base_path($path) : string
{
    return __DIR__ . '/../../' . $path;
}

function qs() : array
{
    return $_GET;
}


// Debugging - var_dump variable
function d($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}


// Debugging - var_dump variable and exit
function dd($value)
{
    d($value);
    exit();
}