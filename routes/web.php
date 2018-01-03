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
    $t = new \AV\Mocks\Client(['test' => 'test']);
    json_decode((string)$t->request('GET', null, [
        'query' => array_merge([
            'function' => 'test',
            'apikey' => env('AV_KEY'),
        ], []),
    ])->getBody(), true);
    return $t->getPayload();
    return json_decode($t->getBody(), true);
    $a = app()->make(\AV\Api\Stock::class);
    dd($a->daily('MSFT', [
    ]));
    return view('react');
})->where('any', '(.*)');
