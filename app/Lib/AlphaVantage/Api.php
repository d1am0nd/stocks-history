<?php

namespace App\Lib\AlphaVantage;

use AlphaVantage\Api as PackageApi;

class Api {

    // Guzzle
    protected $client;

    public function __construct(PackageApi $client)
    {
        $this->client = $client->stock();
    }

    public function getMonthly($symbol)
    {
        return collect($this->client->monthlyAdjusted($symbol)['Monthly Adjusted Time Series'])
            ->map(function ($month, $date) {
                return [
                    'date' => $date,
                    'open' => $month['1. open'],
                    'high' => $month['2. high'],
                    'low' => $month['3. low'],
                    'close' => $month['4. close'],
                    'adjusted_close' => $month['5. adjusted close'],
                    'volume' => $month['6. volume'],
                    'dividend_amount' => $month['7. dividend amount'],
                ];
            });
    }

    public function getDaily($symbol)
    {
        return collect($this->client->dailyAdjusted($symbol)['Time Series (Daily)'])
            ->map(function ($data, $date) {
                return [
                    'date' => $date,
                    'open' => $data['1. open'],
                    'high' => $data['2. high'],
                    'low' => $data['3. low'],
                    'close' => $data['4. close'],
                    'adjusted_close' => $data['5. adjusted close'],
                    'volume' => $data['6. volume'],
                    'dividend_amount' => $data['7. dividend amount'],
                    'split_coefficient' => $data['8. split coefficient'],
                ];
            });
    }

    private function query($symbol, $params = [])
    {
        return json_decode((string)$this->client->request('GET', null, [
            'query' => array_merge([
                'symbol' => $symbol,
                'apikey' => env('AV_KEY'),
            ], $params),
        ])->getBody());
    }
}
