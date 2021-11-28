<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\CollectionController;

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



// Route::middleware(['cors'])->group(function(){
    // Route::get('/csrf_token', function(){
    //     return csrf_token();
    // });
    // Route::post('/register', 'Main\RegisterController@register')->where('id', '[0-9]+');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::post('/login', [AuthenticationController::class, 'login']);
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    Route::post('/loginCheck', [AuthenticationController::class, 'loginCheck']);

    Route::prefix('auth') -> group(function() {
        Route::get('/user', [AuthenticationController::class, 'loginCheck']);
    });

    Route::post('/insert', [CardController::class, 'insert']);
    Route::get('/cardlist', [CardController::class, 'cardlist']);
    Route::get('/search/{search}', [CardController::class, 'search']);
    Route::get('/show/{id}', [CardController::class, 'show']);

    Route::post('/collectioninsert', [CollectionController::class, 'insert']);
    Route::get('/collectionlist', [CollectionController::class, 'collectionlist']);
    Route::get('/collectionshow/{title}', [CollectionController::class, 'show']);
    Route::get('/collectioncardshow/{id}', [CollectionController::class, 'cardshow']);
    Route::patch('/collectionupdate/{title}', [CollectionController::class, 'update']);
    Route::delete('/collectiondestroy/{title}', [CollectionController::class, 'destroy']);
// });