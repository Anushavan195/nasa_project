<?php

use App\Http\Controllers\AsteroidsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/neo')->group(function (){
    Route::post('/hazardous', [AsteroidsController::class, 'index']);
    Route::post('/fastest', [AsteroidsController::class, 'getTheFasterAsteroid']);
    Route::post('/best-year', [AsteroidsController::class, 'getBestYearWithAsteroids']);
    Route::post('/best-month', [AsteroidsController::class, 'getBestMonthWithAsteroids']);
});
