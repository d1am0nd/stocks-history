<?php

namespace App\Models;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Model;

class StockMonth extends Model
{
    protected $casts = [
        'month' => 'date',
        'open' => 'float',
        'high' => 'float',
        'low' => 'float',
        'close' => 'float',
        'adjusted_close' => 'float',
        'volume' => 'integer',
        'dividend_amount' => 'float',
    ];

    protected $fillable = [
        'month',
        'open',
        'high',
        'low',
        'close',
        'adjusted_close',
        'volume',
        'dividend_amount',
    ];

    protected $hidden = [
        'id', 'stock_id', 'created_at', 'updated_at',
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function scopeByMonth($q, $y, $m) {
        return $q->whereMonth('month', $m)->whereYear('month', $y);
    }

    public function scopeOrder($q)
    {
        return $q->orderBy('month', 'ASC');
    }
}
