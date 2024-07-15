<?php

use App\Http\Controllers\SiteController;
use App\Models\DailyRecord;
use App\Models\RandomUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::controller(SiteController::class)->group(function () {
    Route::get('users', "get");
    Route::get('report/daily', "getDailyRecords");
    Route::delete('users/{id}', "delete")->whereUuid('id');
});
