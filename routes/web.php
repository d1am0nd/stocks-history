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
Route::get('{any}', function () {
    $a = app()->make(\AV\Api\Stock::class);
    dd($a->timeSeriesMonthlyAdjusted('MSFT'));
    return view('react');
})->where('any', '(.*)');
