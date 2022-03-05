<?php

use App\Http\Controllers\API\AnnouncementController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\BotApiController;
use App\Http\Controllers\API\CobaController;
use App\Http\Controllers\API\KhotbahController;
use App\Http\Controllers\API\SuperAdmin\UsersController as SuperAdminUsersController;
use App\Http\Controllers\API\UsersController;
use App\Http\Controllers\API\RegionsController;
use App\Http\Controllers\API\SchedulesController;
use App\Http\Controllers\API\YoutubeController;
use Illuminate\Support\Facades\Route;

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

// public

Route::prefix("youtube")->controller(YoutubeController::class)->group(function () {
    Route::get("/upcoming", 'upcoming');
    Route::get("/reset", 'reset');
    Route::get("/", 'index');
});


Route::post('register', [UsersController::class, 'register']);
Route::post('verifyOtp', [UsersController::class, 'verifyOtp']);
Route::post('regenerateOtp', [UsersController::class, 'regenerateOtp']);
Route::post('login', [UsersController::class, 'login']);
Route::post('requestForgot', [UsersController::class, 'forgotPassword']);
Route::put('changePassword', [UsersController::class, 'updatePassword']);

Route::controller(RegionsController::class)->group(function () {
    Route::get("/regions", 'index');
});

Route::prefix("bot")->controller(BotApiController::class)->group(function () {
    Route::post('/telegrams', 'index');
    Route::post('/telegrams/{id}', 'index');
});

Route::post('/coba', [CobaController::class, 'index']);

//middleware
Route::prefix('s')->middleware('auth.superAdmin')->group(function () {
    Route::controller(SuperAdminUsersController::class)->group(function () {
        Route::put('/{id}/u/role/', 'updateRole');
    });
});

Route::middleware('auth.admin')->group(function () {
    Route::controller(RegionsController::class)->group(function () {
        Route::post('/region', 'add');
        Route::put('/region/{id}/u', 'update');
        Route::delete('/region/{id}/d', 'delete');
    });

    Route::controller(SchedulesController::class)->group(function () {
        Route::post('/schedule', 'add');
        Route::put('/schedule/{id}/u', 'update');
        Route::delete('/schedule/{id}/d', 'delete');
    });

    Route::controller(AttendanceController::class)->group(function () {
        Route::put('/attendance/d', 'setAttendance');
    });

    Route::prefix('announcement')->controller(AnnouncementController::class)->group(function () {
        Route::post('/', 'addAnnouncement');
    });
});


Route::middleware('auth.userAdmin')->group(function () {
    Route::controller(AttendanceController::class)->group(function () {
        Route::post('/attendance', 'add');
        Route::get('/attendance/current', 'current');
    });

    Route::controller(SchedulesController::class)->group(function () {
        Route::get("/schedule", 'available');
    });

    Route::prefix('announcement')->controller(AnnouncementController::class)->group(function () {
        Route::get("/", 'index');
        Route::get("/banner", 'banner');
    });

    Route::prefix('khotbah')->controller(KhotbahController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/banner', 'banner');
    });

    Route::prefix("user")->controller(UsersController::class)->group(function () {
        Route::post('/vaccine', 'addVaccine');
        Route::get("vaccine/image/{fileName}", 'showVaccinePicture');
        Route::put("/addProfile", 'addProfilePicture');
    });
});
