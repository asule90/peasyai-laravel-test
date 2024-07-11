<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::patch('/testEvent', function(Request $request) {
    $dr = DailyRecord::inRandomOrder()->first();
    $dr->male_count += 1;
    $dr->save();
});
