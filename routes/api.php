<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\PagSeguroSubscriptionController;
use App\Http\Controllers\SearchCepController;
use App\Models\Plan;
use App\Services\AWS\EmailSenderService;
use App\Services\PagSeguro\PagSeguroSubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/login', [AuthController::class, 'login']);

// User
Route::post('/user', [UserController::class, 'store']);

// Reset Password 
Route::patch('/user/reset_password', [UserController::class, 'reset_password']);

// Search CEP
Route::get('/cep/{cep}', [SearchCepController::class, 'getAddressByCep']);



Route::group(['middleware' => 'auth:api'], function () {
    // Plan
    Route::apiResource('/plan', PlanController::class);
    Route::patch('/pagseguro/plan/{id}/sync', [PagSeguroSubscriptionController::class, 'syncPlan']);

    // User
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    // Phone
    Route::apiResource('/phone', PhoneController::class);
    
    // Address
    Route::apiResource('/address', AddressController::class);

    // Payment method
    Route::apiResource('/payment_method', PaymentMethodController::class);

    // Provider
    Route::apiResource('/provider', ProviderController::class);
    Route::get('/provider/{id}/patients', [ProviderController::class, 'patients']);

    // Patient
    Route::apiResource('/patient', PatientController::class);

    // Diet
    Route::apiResource('/diet', DietController::class);

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});