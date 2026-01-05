<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MenuController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\DashboardController;

// ADMIN
use App\Http\Controllers\Api\Admin\MenuController as AdminMenuController;
use App\Http\Controllers\Api\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Api\Admin\UserController;

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
| REPORT (PUBLIC)
|--------------------------------------------------------------------------
*/
Route::get('/reports/daily', [ReportController::class, 'daily']);
Route::get('/reports/monthly', [ReportController::class, 'monthly']);
Route::get('/reports/user/{userId}', [ReportController::class, 'perUser']);
Route::get('/reports/all', [ReportController::class, 'all']);
Route::get('/reports/transaction/{id}', [ReportController::class, 'perTransaction']);

/*
|--------------------------------------------------------------------------
| AUTHENTICATED USER (KASIR + ADMIN)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    /* =======================
     | MENU (KASIR)
     ======================= */
    Route::get('/menus', [MenuController::class, 'index']);

    /* =======================
     | CATEGORY (READ ONLY - KASIR)
     ======================= */
    Route::get('/categories', [AdminCategoryController::class, 'index']);

    /* =======================
     | TRANSACTION
     ======================= */
    Route::post('/transactions', [TransactionController::class, 'store']);
    Route::get('/transactions/history', [TransactionController::class, 'history']);
    Route::get('/transactions/summary', [TransactionController::class, 'summary']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);

    /* =======================
     | DASHBOARD
     ======================= */
    Route::get('/dashboard/daily-sales', [DashboardController::class, 'dailySales']);
    Route::get('/dashboard/monthly-sales', [DashboardController::class, 'monthlySales']);
    Route::get('/dashboard/payment-method', [DashboardController::class, 'paymentMethod']);
    Route::get('/dashboard/top-items', [DashboardController::class, 'topItems']);

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->prefix('admin')->group(function () {

        /* TRANSACTION ADMIN */
        Route::patch('/transactions/{id}/cancel', [TransactionController::class, 'cancel']);

        /* =======================
         | MENU MASTER
         ======================= */
        Route::get('/menus', [AdminMenuController::class, 'index']);
        Route::post('/menus', [AdminMenuController::class, 'store']);
        Route::get('/menus/{id}', [AdminMenuController::class, 'show']);
        Route::put('/menus/{id}', [AdminMenuController::class, 'update']);
        Route::patch('/menus/{id}/toggle', [AdminMenuController::class, 'toggle']);
        Route::delete('/menus/{id}', [AdminMenuController::class, 'destroy']);

        /* =======================
         | CATEGORY MASTER
         ======================= */
        Route::get('/categories', [AdminCategoryController::class, 'index']);
        Route::post('/categories', [AdminCategoryController::class, 'store']);
        Route::put('/categories/{id}', [AdminCategoryController::class, 'update']);
        Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy']);

        /* =======================
         | USER / KASIR MASTER
         ======================= */
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'store']);
        Route::put('/users/{id}', [UserController::class, 'update']);
        Route::patch('/users/{id}', [UserController::class, 'toggle']);
        Route::delete('/users/{id}', [UserController::class, 'destroy']);
    });
});
