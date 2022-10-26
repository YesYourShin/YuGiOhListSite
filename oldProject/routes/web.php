<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\OricaController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


Route::post('/insert', [CardController::class, 'insert']);
Route::get('/cardlistpage', [CardController::class, 'cardlistpage'])->name('cardlistpage');
Route::get('/cardlist', [CardController::class, 'cardlist'])->name('cardlist');
Route::get('/search/{search}', [CardController::class, 'search']);
Route::get('/show/{id}', [CardController::class, 'show']);

Route::post('/collectioninsert', [CollectionController::class, 'insert']);
Route::get('/collectionlist', [CollectionController::class, 'collectionlist'])->name('collectionlist');
Route::get('/collectionlistpage', [CollectionController::class, 'collectionlistpage'])->name('collectionlistpage');
Route::get('/collectionsearch/{search}', [CollectionController::class, 'search']);
Route::get('/collectionshow/{id}', [CollectionController::class, 'show']);
Route::patch('/collectionupdate/{id}', [CollectionController::class, 'update']);
Route::delete('/collectiondestroy/{id}', [CollectionController::class, 'destroy']);

Route::post('/oricainsert', [OricaController::class, 'insert']);
Route::get('/oricalist', [OricaController::class, 'oricalist'])->name('oricalist');
Route::get('/oricalistpage', [OricaController::class, 'oricalistpage'])->name('oricalistpage');
Route::get('/oricasearch/{search}', [OricaController::class, 'search']);
Route::get('/oricashow/{id}', [OricaController::class, 'show']);
Route::get('/oricacheck/{id}', [OricaController::class, 'check']);
Route::get('/oricaform', function () {
    return Inertia::render('Card/OricaForm');
});
Route::delete('/oricadestroy/{id}', [OricaController::class, 'destroy']);
Route::get('/orica/{id}/edit', [OricaController::class, 'edit']);
Route::patch('/oricaupdate/{id}', [OricaController::class, 'update']);
Route::get('/myoricalist', [OricaController::class, 'myoricalist'])->name('myoricalist');
Route::get('/myoricalistpage', [OricaController::class, 'myoricalistpage'])->name('myoricalistpage');
Route::get('/myoricasearch/{search}', [OricaController::class, 'mysearch']);
// Route::post('/myoricalist', [OricaController::class, 'myoricalist']);