<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KhotbahController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get("/logout", [UserController::class, 'logout']);

Route::prefix('login')->group(function () {

    Route::get("/", function () {
        return view('auth.login');
    });

    Route::post("/", [UserController::class, 'login']);
});

Route::middleware('auth.web')->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::prefix('schedule')->controller(ScheduleController::class)->group(function () {
        Route::get('/',  'index');
        Route::get('/create',  'create');
        Route::put('reset', 'resetSchedule');
        Route::delete('reset', 'deleteActive');
        Route::post('/', 'add');
        Route::get('/{id}/u/', 'edit');
        Route::put('/{id}',  'update');
        Route::delete('/{id}/d',  'delete');
    });

    Route::prefix('khotbah')->controller(KhotbahController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/create', 'create');
        Route::post('/', 'store');
        Route::get('/{id}/u/', 'edit');
        Route::put('/{id}', 'update');
        Route::delete('/{id}/d',  'destroy');
    });

    Route::prefix('announcement')->controller(AnnouncementController::class)->group(function () {
        Route::get("/", 'index');
        Route::get("/create", 'create');
        Route::post("/", 'store');
        Route::get("/{id}/u/", 'edit');
        Route::put("/{id}", 'update');
        Route::delete("/{id}/d", 'destroy');
    });

    Route::prefix('attendance')->controller(AttendanceController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/history', 'history');
        Route::get('/history/{year}/{month}', 'historyData');
    });
});

Route::middleware('auth.web.super')->group(function () {
    Route::prefix('region')->controller(RegionController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}/u/', 'edit');
    });
});
