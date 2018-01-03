<?php

namespace AV\Api;

use AV\API\Master;
use GuzzleHttp\Client;
use AV\Exception\BadMethodCallException;

class Technical extends Master {

    /* Available AlphaVantage technical functions */

    // https://www.alphavantage.co/documentation/#sector
    const SECTOR = 'SECTOR';
    // 123
    const SECTOR = 'SECTOR';

    private $availableFunctions = [
        self::SECTOR,
    ];

    /**
     * SECTOR
     * @param  string $params   Additional params
     * @return Response object
     */
    public function sector($params = [])
    {
        return $this->query(self::SECTOR, $params);
    }

    /**
     * Checks if the provided function name is available
     * @param  string $name Name of the AV function to execute
     * @return boolean
     */
    protected function funcAvailable($name)
    {
        return in_array($name, $this->availableFunctions);
    }
}
