<?php

return [

    /*
    |--------------------------------------------------------------------------
    | External Source
    |--------------------------------------------------------------------------
    |
    | This value will be used to determine the external source of the data.
    |
    */

    // The external URL to fetch the data from.
    'external_url' => env('EXTERNAL_SOURCE_URL'),

    // The external API key to fetch the data from.
    'external_key' => env('EXTERNAL_SOURCE_KEY'),

    // Path to the data array in the response, separated by dots (.)
    'external_data_path' => env('EXTERNAL_SOURCE_DATA_PATH'),
];
