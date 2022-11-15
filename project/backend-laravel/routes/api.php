<?php

use App\Http\Controllers\JaCardController;
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
Route::post('register', [PassportAuthController::class, 'register']);
Route::post('login', [PassportAuthController::class, 'login']);
Route::middleware('auth:api')->group(function () {
    Route::post('logout',  [PassportAuthController::class, 'logout']);
    Route::post('create', [JaCardController::class, 'create']);
    Route::post('update', [JaCardController::class, 'update']);
    Route::post('destroy', [JaCardController::class, 'destroy']);
    Route::get('myinfo',  [PassportAuthController::class, 'myInfo']);
});
