<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - Free Fire Event & Super Admin Panel
|--------------------------------------------------------------------------
*/

// Frontend Event Routes
Route::get('/', [EventController::class, 'index'])->name('event.index');
Route::post('/verify', [EventController::class, 'verify'])->name('event.verify');

// Admin Authentication
Route::get('/panel/login', [AdminController::class, 'login'])->name('panel.login');
Route::post('/panel/login', [AdminController::class, 'postLogin'])->name('panel.login.post');
Route::any('/panel/logout', [AdminController::class, 'logout'])->name('panel.logout');

// Super Admin Protected Panel
Route::prefix('panel')->middleware('admin.auth')->name('panel.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Frontend Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    Route::post('/telegram/test', [AdminController::class, 'testTelegram'])->name('telegram.test');
    
    // Item Management
    Route::get('/items', [AdminController::class, 'items'])->name('items');
    Route::post('/items', [AdminController::class, 'storeItem'])->name('items.store');
    Route::post('/items/{id}/update', [AdminController::class, 'updateItem'])->name('items.update');
    Route::post('/items/{id}/delete', [AdminController::class, 'deleteItem'])->name('items.delete');
    Route::post('/items/{id}/toggle', [AdminController::class, 'toggleItem'])->name('items.toggle');

    // Claim Logs
    Route::get('/claims', [AdminController::class, 'claims'])->name('claims');
    Route::get('/claims/export', [AdminController::class, 'exportClaimsCsv'])->name('claims.export');
    Route::post('/claims/clear', [AdminController::class, 'clearClaims'])->name('claims.clear');
    Route::post('/claims/{id}/delete', [AdminController::class, 'deleteClaim'])->name('claims.delete');
});
