<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('app');
});

Route::get('/import',[CustomerController::class,'import']);
Route::post('/import',[CustomerController::class,'storeExcel']);

Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');