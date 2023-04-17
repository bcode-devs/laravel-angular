<?php


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

Route::prefix('api')->group(static function (): void {
    Route::get('', static function () {
        return ['X-API-VERSION' => config('shared.api.version')];
    })->name('x-api-version');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/get', [\App\Http\Controllers\GetController::class, 'get']);
});
