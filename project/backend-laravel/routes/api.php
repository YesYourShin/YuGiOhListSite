<?php

use App\Http\Controllers\JaCardController;
use App\Http\Controllers\KoCardController;
use App\Http\Controllers\PassportAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// post put patch delete 등의 메소드 사용법 찾아보기

Route::prefix('auth')->group(function () {
    Route::post('register', [PassportAuthController::class, 'register']);
    Route::post('login', [PassportAuthController::class, 'login']);
    Route::middleware('auth:api')->group(function () {
        Route::post('logout',  [PassportAuthController::class, 'logout']);
        Route::get('myinfo',  [PassportAuthController::class, 'myinfo']);
    });
});

Route::prefix('card')->group(function () {
    Route::prefix('ko')->group(function () {
        Route::get('index', [KoCardController::class, 'index']);
        Route::get('/show/{id}', [KoCardController::class, 'show']);
        Route::middleware('auth:api')->group(function () {
            // 관리자만 할 수 있는 store로 바꾸기
            Route::post('store',  [KoCardController::class, 'store']);
            // usercardstore에서 create update destroy 다 함
            Route::post('usercardstore',  [KoCardController::class, 'userCardStore']);
            Route::get('usercardindex',  [KoCardController::class, 'userCardIndex']);
        });
    });
    Route::prefix('ja')->group(function () {
        Route::get('index', [JaCardController::class, 'index']);
        Route::get('/show/{id}', [JaCardController::class, 'show']);
        Route::middleware('auth:api')->group(function () {
            // 관리자만 할 수 있는 store로 바꾸기
            Route::post('store',  [JaCardController::class, 'store']);
            // usercardstore에서 create update destroy 다 함
            Route::post('usercardstore',  [JaCardController::class, 'userCardStore']);
            Route::get('usercardindex',  [JaCardController::class, 'userCardIndex']);
        });
    });
});
