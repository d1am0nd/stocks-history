<?php

namespace App\Lib\AlphaVantage;

use App\Models\Stock;
use App\Models\StockMonth;
use App\Lib\AlphaVantage\Api;

class Database {

    // Stock model
    protected $stockModel;

    // Stock month model
    protected $monthModel;

    // Api abstraction
    protected $api;

    public function __construct(Stock $model, StockMonth $monthModel, Api $api)
    {
        $this->api = $api;
        $this->stockModel = $model;
        $this->monthModel = $monthModel;
    }

    public function updateMonthly($symbol)
    {
        $db = $this->stockModel->bySymbol($symbol)->first();
        if ($db === null) {
            $db = new $this->stockModel;
            $db->symbol = $symbol;
            $db->save();
        }

        $r = $this->api->getMonthly($symbol);

        foreach ($r as $month => $data) {
            $date = \Carbon\Carbon::parse($month);
            $dbm = $db
                ->months()
                ->byMonth($date->year, $date->month)
                ->first();

            if ($dbm !== null) {
                continue;
            }
            $dbm = new $this->monthModel;
            $dbm->fill($data);
            $dbm->month = $date->format('Y-m-d');
            $dbm->stock_id = $db->id;
            $dbm->save();
        }

        return $r;
    }
}
