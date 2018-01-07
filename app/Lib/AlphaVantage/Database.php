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

    public function updateMonthly(Stock $stock)
    {
        $last = $this->monthModel
            ->where('stock_id', $stock->id)
            ->orderBy('date', 'DESC')
            ->first();

        $r = $this->api->getMonthly($stock->symbol);
        foreach ($r as $month => $data) {
            $date = Carbon::parse($month);
            if ($last !== null && $date <= $last->date) {
                continue;
            }
            $dbm = $stock
                ->months()
                ->byMonth($date->year, $date->month)
                ->first();

            if ($dbm !== null) {
                continue;
            }
            $dbm = new $this->monthModel;
            $dbm->fill($data);
            $dbm->date = $date->format('Y-m-d');
            $dbm->stock_id = $stock->id;
            $dbm->save();
        }

        return $r;
    }

    public function updateDaily(Stock $stock)
    {
        $last = $this->dayModel
            ->where('stock_id', $stock->id)
            ->orderBy('date', 'DESC')
            ->first();

        $r = $this->api->getDaily($stock->symbol);
        foreach ($r as $day => $data) {
            $date = Carbon::parse($day);
            if ($last !== null && $date <= $last->date) {
                continue;
            }
            $dbm = $stock
                ->days()
                ->byDay($date->year, $date->month, $date->day)
                ->first();

            if ($dbm !== null) {
                continue;
            }
            $dbm = new $this->dayModel;
            $dbm->fill($data);
            $dbm->date = $date->format('Y-m-d');
            $dbm->stock_id = $stock->id;
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
