<?php

namespace Av;

use AV\Api\Stock;
use AV\Api\Sector;
use AV\Api\General;
use AV\Api\Currency;
use AV\Api\DigitalCurrency;
use AV\Guzzle\Client;
use PHPUnit\Framework\TestCase;

class Api
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

    public static function general()
    {
        return self::make(General::class);
    }

    private static function make($api)
    {
        return new $api(new Client([
            'base_uri' => 'https://www.alphavantage.co/query',
        ]), env('AV_KEY'));
    }
}
