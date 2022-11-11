<?php

use App\Http\Controllers\JaCardController;
use App\Http\Controllers\KoCardController;
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
    Route::post('/store', [KoCardController::class, 'store']);

});

Route::prefix('ja')->group(function () {
    Route::get('/index', [JaCardController::class, 'index']);
    Route::post('/store', [JaCardController::class, 'store']);
    Route::get('/show/{id}', [JaCardController::class, 'show']);

});
