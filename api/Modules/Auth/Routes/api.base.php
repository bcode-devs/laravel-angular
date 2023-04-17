<?php

use Modules\Auth\Http\Middleware\AuthJwtTokenMiddleware;
use Modules\Auth\Http\Controllers\API\OAuthController;
use Modules\Auth\Http\Controllers\API\ResetController;
use Modules\Auth\Http\Controllers\API\AuthController;

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

Route::prefix('api')->middleware(['api', 'shared.throttle', 'shared.db.log', 'auth.sanctum'])
    ->group(static function (): void {
        // Auth | routes
        Route::group(['prefix' => 'auth', 'as' => 'auth.'], static function (): void {
            // User signUp | signIn
            Route::post('sign-up', [AuthController::class, 'signUp'])->name('sign-up');
            Route::post('sign-in', [AuthController::class, 'signIn'])->name('sign-in');
            // Verify user
            Route::post('verify-email', [AuthController::class, 'verifyEmail'])
                ->middleware('guest:sanctum')
                ->name('verify-email');
            // Social auth
            Route::group(['middleware' => 'guest:sanctum', 'as' => 'oauth.'], static function () {
                Route::any('oauth/{driver}/callback', [OAuthController::class, 'handleProviderCallback'])
                    ->name('callback');
                Route::post('oauth/{driver}', [OAuthController::class, 'redirectToProvider'])
                    ->name('redirect');
            });
            // Reset password
            Route::group([
                'prefix' => 'reset', 'as' => 'reset.', 'middleware' => ['guest:sanctum', 'shared.throttle:10,1']
            ], static function (): void {
                Route::post('email', [ResetController::class, 'email'])->name('email');
                Route::post('code', [ResetController::class, 'code'])->name('code');
                Route::post('password', [ResetController::class, 'password'])->name('password');
            });
        });
    });
