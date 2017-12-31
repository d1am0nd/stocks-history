<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockDay extends Model
{
    protected $casts = [
        'date' => 'date',
        'open' => 'float',
        'high' => 'float',
        'low' => 'float',
        'close' => 'float',
        'adjusted_close' => 'float',
        'volume' => 'integer',
        'dividend_amount' => 'float',
        'split_coefficient' => 'float',
    ];

    protected $fillable = [
        'date',
        'open',
        'high',
        'low',
        'close',
        'adjusted_close',
        'volume',
        'dividend_amount',
        'split_coefficient',
    ];

    protected $hidden = [
        'id', 'stock_id', 'created_at', 'updated_at',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function scopeByDay($q, $y, $m, $d)
    {
        return $q->whereMonth('date', $m)->whereYear('date', $y)->whereDay('date', $d);
    }

    public function scopeOrder($q)
    {
        return $q->orderBy('date', 'ASC');
    }
}
