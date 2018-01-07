<?php

namespace App\Models;

use App\Models\StockDay;
use App\Models\StockMonth;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected $hidden = [
        'id', 'created_at', 'updated_at',
    ];

    public function months()
    {
        return $this->monthsClean()->order();
    }

    public function month()
    {
        return $this->hasOne(StockMonth::class);
    }

    public function monthsClean()
    {
        return $this->hasMany(StockMonth::class);
    }

    public function days()
    {
        return $this->daysClean()->order();
    }

    public function day()
    {
        return $this->hasOne(StockDay::class);
    }

    public function daysClean()
    {
        return $this->hasMany(StockDay::class);
    }

    public function scopeBySymbol($q, $symbol)
    {
        return $q->where('symbol', $symbol);
    }
}
