<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;

Route::prefix('v1')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */

    // Login
    Route::post('/auth/login', [AuthController::class, 'login']);

    // Logout (requiere token)
    Route::middleware('auth:sanctum')->post('/auth/logout', [AuthController::class, 'logout']);


    /*
    |--------------------------------------------------------------------------
    | RUTA PROTEGIDA DE PRUEBA
    |--------------------------------------------------------------------------
    */

    Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
        return response()->json([
            'success' => true,
            'message' => 'Usuario autenticado correctamente.',
            'data' => [
                'id' => $request->user()->id,
                'name' => $request->user()->name,
                'email' => $request->user()->email,
                'role' => $request->user()->role,
            ],
        ]);
    });

});
