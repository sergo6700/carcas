<?php

require_once __DIR__ . '/../app/Api/Helpers/constants.php';

return [
    /*
    |--------------------------------------------------------------------------
    | Default Options
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        // Max price
        'max_price' => 499,

        // Min price
        'min_price' => 0,

        // Max stay
        'max_stay' => 999,

        // Min stay
        'min_stay' => 1,

        // Cta
        'cta' => \ConstGeneralStatuses::NO,

        // Ctd
        'ctd' => \ConstGeneralStatuses::NO,

        // Stop Sell
        'stop_sell' => \ConstGeneralStatuses::NO,

        // Cut Off
        'cut_off' => 0,
    ]
];
