<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\UserController;
use App\Models\Plan;
use App\Services\PagSeguro\PagSeguroSubscriptionService;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/login', [AuthController::class, 'login']);

// User
Route::post('/user', [UserController::class, 'store']);

// Plan
Route::apiResource('/plan', PlanController::class);

Route::get('/pagseguro/plan/{id}/sync', function ($id) {
    $plan = Plan::find($id);

    $service = new PagSeguroSubscriptionService();
    $response = $service->createPlan($plan);

    return response()->json($response, 200);
});

Route::group(['middleware' => 'auth:api'], function () {
    // User
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    // Phone
    Route::apiResource('/phone', PhoneController::class);

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});