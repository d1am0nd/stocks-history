<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StocksController extends Controller
{

    // Stock model
    private $stock;

    public function __construct(Stock $stock)
    {
        $this->stock = $stock;
    }

    public function months($symbol)
    {
        $stock = $this
            ->stock
            ->bySymbol($symbol)
            ->with('months')
            ->firstOrFail();

        return response()->json($stock);
    }

}
