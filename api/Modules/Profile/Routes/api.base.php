<?php

use Modules\Profile\Http\Controllers\API\Profile\AvatarController;
use Modules\Profile\Http\Controllers\API\Profile\ProfileController;

// Profile module | API
Route::group(['prefix' => 'api', 'middleware' => ['api', 'auth.sanctum', 'shared.db.log']], static function (): void {
    // Profile | module
    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'middleware' => 'auth:sanctum'], static function (): void {
        // user profile | user
        Route::get('info', [ProfileController::class, 'info'])->name('info');
        Route::post('setting', [ProfileController::class, 'setting'])->name('setting');
        // user profile | avatar
        Route::group(['prefix' => 'avatar', 'as' => 'avatar'], static function (): void {
            Route::post('save', [AvatarController::class, 'save'])->name('save');
            Route::post('delete', [AvatarController::class, 'delete'])->name('delete');
        });
    });
});
