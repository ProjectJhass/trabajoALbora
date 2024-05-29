<?php

use App\Http\Controllers\api\control_madera\ControllerAuthUser;
use App\Http\Controllers\api\control_madera\ControllerUpdateInfoMovil;
use App\Http\Controllers\api\ItemsActivosSiesa;
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

Route::get('itemsActivos', [ItemsActivosSiesa::class, 'index']);
Route::post('itemInfo', [ItemsActivosSiesa::class, 'ObtenerPrecioProductoBuscado']);

Route::group(['prefix' => 'madera', 'middleware' => 'maderaApi'], function () {
    Route::post('/medidas-madera', [ControllerUpdateInfoMovil::class, 'saveInfoMedidasMadera']);
    Route::group(['prefix' => 'auth'], function () {
        Route::post('/login', [ControllerAuthUser::class, 'authUser']);
    });
});
