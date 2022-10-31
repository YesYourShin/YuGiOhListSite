<?php

use App\Http\Controllers\CardJPController;
use App\Http\Controllers\CardKRController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('kr')->group(function () {
    Route::post('/store', [CardKRController::class, 'storeCard']);

});

Route::prefix('jp')->group(function () {
    Route::post('/store', [CardJPController::class, 'storeCard']);

});
