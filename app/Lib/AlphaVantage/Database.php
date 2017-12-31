<?php

namespace App\Lib\AlphaVantage;

use Carbon\Carbon;
use App\Models\Stock;
use App\Models\StockDay;
use App\Models\StockMonth;
use App\Lib\AlphaVantage\Api;

class Database {

    // Stock model
    protected $stockModel;

    // Stock month model
    protected $monthModel;

    // Stock day model
    protected $dayModel;

    // Api abstraction
    protected $api;

    public function __construct(Stock $model, StockMonth $monthModel, StockDay $dayModel, Api $api)
    {
        $this->api = $api;
        $this->stockModel = $model;
        $this->monthModel = $monthModel;
        $this->dayModel = $dayModel;
    }

    public function updateMonthly($symbol, $name)
    {
        $db = $this->existingOrNewStock($symbol, $name);

        $r = $this->api->getMonthly($symbol);

        foreach ($r as $month => $data) {
            $date = Carbon::parse($month);
            $dbm = $db
                ->months()
                ->byMonth($date->year, $date->month)
                ->first();

            if ($dbm !== null) {
                continue;
            }
            $dbm = new $this->monthModel;
            $dbm->fill($data);
            $dbm->date = $date->format('Y-m-d');
            $dbm->stock_id = $db->id;
            $dbm->save();
        }

        return $r;
    }

    public function updateDaily($symbol, $name)
    {
        $db = $this->existingOrNewStock($symbol, $name);

        $r = $this->api->getDaily($symbol);
        foreach ($r as $day => $data) {
            $date = Carbon::parse($day);
            $dbm = $db
                ->days()
                ->byDay($date->year, $date->month, $date->day)
                ->first();

            if ($dbm !== null) {
                continue;
            }
            $dbm = new $this->dayModel;
            $dbm->fill($data);
            $dbm->date = $date->format('Y-m-d');
            $dbm->stock_id = $db->id;
            $dbm->save();
        }

        return $r;
    }

    private function existingOrNewStock($symbol, $name)
    {
        $db = $this->stockModel->bySymbol($symbol)->first();
        if ($db === null) {
            $db = new $this->stockModel;
            $db->symbol = $symbol;
            $db->name = $name;
            $db->save();
        }
        return $db;
    }
}
