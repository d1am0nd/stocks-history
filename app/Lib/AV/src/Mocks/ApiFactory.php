<?php

namespace Av\Mocks;

use AV\Api\Stock;
use AV\Api\Sector;
use AV\Api\Currency;
use AV\Api\DigitalCurrency;
use AV\Mocks\Client;
use PHPUnit\Framework\TestCase;

class ApiFactory
{
    public static function currency()
    {
        return self::make(Currency::class);
    }

    public static function digitalCurrency()
    {
        return self::make(DigitalCurrency::class);
    }

    public static function sectro()
    {
        return self::make(Sector::class);
    }

    public static function stock()
    {
        return self::make(Stock::class);
    }

    private static function make($api)
    {
        return new $api(new Client([
            'base_uri' => 'https://www.alphavantage.co/query',
        ]), 123456789);
    }
}
