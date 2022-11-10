<?php

use App\Http\Controllers\CardJAController;
use App\Http\Controllers\CardKOController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('ko')->group(function () {
    Route::post('/store', [CardKOController::class, 'store']);

});

Route::prefix('ja')->group(function () {
    Route::get('/index', [CardJAController::class, 'index']);
    Route::post('/store', [CardJAController::class, 'store']);
    Route::get('/show/{id}', [CardJAController::class, 'show']);

});
