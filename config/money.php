<?php

return [
    'locale' => config('app.locale', 'en_US'),
    'defaultCurrency' => config('app.currency', 'USD'),
    'defaultFormatter' => null,
    'currencies' => [
        'iso' => ['BYN', 'RUB', 'USD', 'EUR'],  // 'all' to choose all ISOCurrencies
        'bitcoin' => ['XBT'], // 'all' to choose all BitcoinCurrencies
        'custom' => []
    ]
];
