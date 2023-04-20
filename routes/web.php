<?php

use App\Http\Controllers\AsteroidsController;
use Illuminate\Support\Facades\Route;

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
    Route::post('/{period}', [AsteroidsController::class, 'getBestPeriodWithAsteroids'])->where([
        'period' => 'best-year|best-month'
    ]);
});
