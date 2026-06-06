<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProjectController;

Route::prefix('admin')->middleware(['auth:sanctum', 'role:superadmin'])->group(function () {
    Route::get('/stats', [DashboardController::class, 'getStats']);
    Route::post('/projects/reorder', [ProjectController::class, 'reorder']);
    Route::post('/bulk-delete', [DashboardController::class, 'bulkDelete']);
    Route::get('/export/{type}', [DashboardController::class, 'export']);
});