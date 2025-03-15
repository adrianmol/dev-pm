<?php

use DevPM\Application\Company\Communication\Controller\Api\CompanyApiController;
use DevPM\Application\Project\Communication\Controller\Api\ProjectApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/project')->middleware(['auth:sanctum'])->group(function () {
    Route::post('create', [ProjectApiController::class, 'createAction'])
        ->name('api.project.create');
    Route::get('{id}/view', [ProjectApiController::class, 'viewAction'])
        ->name('api.project.view');
    Route::get('{id}/update', [ProjectApiController::class, 'updateAction'])
        ->name('api.project.update');
    Route::delete('{id}/delete', [ProjectApiController::class, 'deleteAction'])
        ->name('api.project.view');
    Route::get('list', [ProjectApiController::class, 'listAction'])
        ->name('api.project.list');
});
