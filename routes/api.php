<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Api\Admin\CategoryController;
/*
|--------------------------------------------------------------------------
| HEALTH CHECK
|--------------------------------------------------------------------------
*/
Route::get('/health', fn () => response()->json(['status' => 'API OK']));

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| REPORT PDF (PUBLIC / TANPA AUTH)
|--------------------------------------------------------------------------
*/
Route::get('/reports/daily', [ReportController::class, 'daily']);
Route::get('/reports/monthly', [ReportController::class, 'monthly']);
Route::get('/reports/user/{userId}', [ReportController::class, 'perUser']);
Route::get('/reports/all', [ReportController::class, 'all']);
Route::get('/reports/transaction/{id}', [ReportController::class, 'perTransaction']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout']);

    /*
    |--------------------------------------------------------------------------
    | MENU
    |--------------------------------------------------------------------------
    */
    Route::get('/menus', [MenuController::class, 'index']);

    /*
    |--------------------------------------------------------------------------
    | TRANSACTION
    |--------------------------------------------------------------------------
    */
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/history', [TransactionController::class, 'history']);
    Route::get('/transactions/summary', [TransactionController::class, 'summary']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (SEMUA USER LOGIN)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard/daily-sales', [DashboardController::class, 'dailySales']);
    Route::get('/dashboard/monthly-sales', [DashboardController::class, 'monthlySales']);
    Route::get('/dashboard/payment-method', [DashboardController::class, 'paymentMethod']);
    Route::get('/dashboard/top-items', [DashboardController::class, 'topItems']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        Route::patch('/transactions/{id}/cancel', [TransactionController::class, 'cancel']);

        Route::middleware('admin')->group(function () {

        Route::get('/admin/menus', [AdminMenuController::class, 'index']);
        Route::post('/admin/menus', [AdminMenuController::class, 'store']);
        Route::get('/admin/menus/{id}', [AdminMenuController::class, 'show']);
        Route::put('/admin/menus/{id}', [AdminMenuController::class, 'update']);
        Route::delete('/admin/menus/{id}', [AdminMenuController::class, 'destroy']);
        Route::patch('/admin/menus/{id}/toggle', [AdminMenuController::class, 'toggle']);
        Route::get('/admin/categories', [CategoryController::class, 'index']);
        Route::post('/admin/categories', [CategoryController::class, 'store']);
        Route::put('/admin/categories/{id}', [CategoryController::class, 'update']);
        Route::delete('/admin/categories/{id}', [CategoryController::class, 'destroy']);
});
    });
});
