<?php

use DevPM\Application\User\Communication\Controller\Api\UserApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/user')->middleware([])->group(function () {
    Route::post('register', [UserApiController::class, 'registerAction'])
        ->name('api.user.register');
    Route::post('login', [UserApiController::class, 'loginAction'])
        ->name('api.user.login');
    Route::post('logout', [UserApiController::class, 'logoutAction'])
        ->name('api.user.logout')
        ->middleware(['auth:sanctum']);
    Route::get('list', [UserApiController::class, 'listAction'])
        ->name('api.user.list')
        ->middleware(['auth:sanctum']);
});
