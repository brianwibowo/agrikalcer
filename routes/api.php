<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SensorDataController; // Tambahkan titik koma di akhir
use App\Http\Controllers\PVDataController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/send-sensor-data', [SensorDataController::class, 'store'])->withoutMiddleware('auth:api');
Route::post('/send-pv-data', [PVDataController::class, 'store'])->withoutMiddleware('auth:api');


