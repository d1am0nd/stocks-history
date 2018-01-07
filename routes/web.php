<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('addstock', function () {
    return view('addstock');
});
Route::post('addstock', function () {
    if (request()->input('password') !== env('ADD_STOCK_PASSWORD')) {
        return 'wrong pass';
    }
    $stock = \App\Models\Stock::bySymbol(request()->input('symbol'))->first();
    if ($stock !== null) {
        return 'Already in';
    }
    $stock = new \App\Models\Stock;
    $stock->symbol = request()->input('symbol');
    $stock->name = request()->input('name');
    $stock->save();

    return "Added $stock->name";
});

Route::get('{any}', function () {
    return view('react');
})->where('any', '(.*)');
