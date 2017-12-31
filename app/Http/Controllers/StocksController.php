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

    public function stocks()
    {
        return response()
            ->json(
                $this->stock->get()
            );
    }

    public function days($symbol)
    {
        $stock = $this
            ->stock
            ->bySymbol($symbol)
            ->with('days')
            ->firstOrFail();

        return response()->json($stock);
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
