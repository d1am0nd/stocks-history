<?php

namespace App\Lib\AlphaVantage;

use GuzzleHttp\Client;

class Api {

    // Guzzle
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = new $client([
            'base_uri' => 'https://www.alphavantage.co/query',
        ]);
    }

    public function getMonthly($symbol)
    {
        return collect($this->query($symbol, [
            'function' => 'TIME_SERIES_MONTHLY_ADJUSTED'
        ])
        ->{'Monthly Adjusted Time Series'})
        ->map(function ($month, $date) {
            return [
                'date' => $date,
                'open' => $month->{'1. open'},
                'high' => $month->{'2. high'},
                'low' => $month->{'3. low'},
                'close' => $month->{'4. close'},
                'adjusted_close' => $month->{'5. adjusted close'},
                'volume' => $month->{'6. volume'},
                'dividend_amount' => $month->{'7. dividend amount'},
            ];
        });
    }

    public function getDaily($symbol)
    {
        return collect($this->query($symbol, [
            'function' => 'TIME_SERIES_DAILY_ADJUSTED',
            'outputsize' => 'full',
        ])
        ->{'Time Series (Daily)'})
        ->map(function ($data, $date) {
            return [
                'date' => $date,
                'open' => $data->{'1. open'},
                'high' => $data->{'2. high'},
                'low' => $data->{'3. low'},
                'close' => $data->{'4. close'},
                'adjusted_close' => $data->{'5. adjusted close'},
                'volume' => $data->{'6. volume'},
                'dividend_amount' => $data->{'7. dividend amount'},
                'split_coefficient' => $data->{'8. split coefficient'},
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
