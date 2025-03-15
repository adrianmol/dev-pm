<?php

use DevPM\Application\Company\Communication\Controller\Api\CompanyApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/company')->middleware(['auth:sanctum'])->group(function () {
    Route::post('create', [CompanyApiController::class, 'createAction'])
        ->name('api.company.create');
    Route::put('{companyId}/update', [CompanyApiController::class, 'updateAction'])
        ->name('api.company.update');
    Route::delete('{companyId}/delete', [CompanyApiController::class, 'deleteAction'])
        ->name('api.company.delete');
    Route::get('{id}/view', [CompanyApiController::class, 'viewAction'])
        ->name('api.company.view');
    Route::get('list', [CompanyApiController::class, 'listAction'])
        ->name('api.company.list');
});
