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
        return $this->hasMany(StockMonth::class)->order();
    }

    public function days()
    {
        return $this->hasMany(StockDay::class)->order();
    }

    public function scopeBySymbol($q, $symbol)
    {
        return $q->where('symbol', $symbol);
    }
}
