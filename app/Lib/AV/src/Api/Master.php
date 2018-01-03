<?php

namespace AV\Api;

use GuzzleHttp\Client;
use AV\Exception\BadDataTypeException;
use AV\Exception\BadMethodCallException;

abstract class Master {

    // Guzzle
    protected $client;

    abstract protected function funcAvailable($funcName);

    public function __construct(Client $client)
    {
        $this->client = new $client([
            'base_uri' => 'https://www.alphavantage.co/query',
        ]);
    }

    /**
     * Queries AlphaVantage API for type JSON and decodes response to an array
     * @param  string $func   Exact name of the AlphaVantage API function
     * @param  array  $params Additional API params
     * @return Object         Decoded API object
     */
    public function query($func, $params = [])
    {
        if (!$this->funcAvailable($func)) {
            throw new BadMethodCallException($func);
        }
        if (isset($params['datatype']) && $params['datatype'] !== 'json') {
            throw new BadDataTypeException($params['datatype']);
        }
        return json_decode((string)$this->client->request('GET', null, [
            'query' => array_merge([
                'function' => $func,
                'apikey' => env('AV_KEY'),
            ], $params),
        ])->getBody(), true);
    }
}
