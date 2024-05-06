<?php

use App\Data\PagSeguro\Request\SubscriptionDTO;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\FinancialTransactionController;
use App\Http\Controllers\PagSeguroPlanController;
use App\Http\Controllers\PagSeguroSubscriberController;
use App\Http\Controllers\PagSeguroSubscriptionController;
use App\Http\Controllers\SearchCepController;
use App\Http\Controllers\SubscriptionController;
use App\Models\Subscription;
use App\Models\User;
use App\Services\PagSeguro\PagSeguroSubscriberService;
use Illuminate\Support\Facades\Route;

// Auth
Route::post('/login', [AuthController::class, 'login']);

// User
Route::post('/user', [UserController::class, 'store']);

// Reset Password 
Route::patch('/user/reset_password', [UserController::class, 'reset_password']);

// Search CEP
Route::get('/cep/{cep}', [SearchCepController::class, 'getAddressByCep']);

// Provider
Route::post('/provider', [ProviderController::class, 'store']);

Route::group(['middleware' => 'auth:api'], function () {
    // Plan
    Route::apiResource('/plan', PlanController::class);
    Route::patch('/pagseguro/plan/{id}/sync', [PagSeguroPlanController::class, 'sync']);

    // User
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);
    Route::patch('/pagseguro/subscriber/{id}/sync', [PagSeguroSubscriberController::class, 'sync']);

    // Phone
    Route::apiResource('/phone', PhoneController::class);
    
    // Address
    Route::apiResource('/address', AddressController::class);

    // Payment method
    Route::apiResource('/payment_method', PaymentMethodController::class);

    // Provider
    Route::get('/provider', [ProviderController::class, 'index']);
    Route::get('/provider/{id}', [ProviderController::class, 'show']);
    Route::put('/provider/{id}', [ProviderController::class, 'update']);
    Route::delete('/provider/{id}', [ProviderController::class, 'destroy']);
    Route::get('/provider/{id}/patients', [ProviderController::class, 'patients']);

    // Subscription
    Route::apiResource('/subscription', SubscriptionController::class);
    Route::patch('/pagseguro/subscription/{id}/sync', [PagSeguroSubscriptionController::class, 'sync']);

    // Patient
    Route::apiResource('/patient', PatientController::class);

    // Financial Transaction
    Route::apiResource('/financial_transaction', FinancialTransactionController::class);

    // Diet
    Route::apiResource('/diet', DietController::class);

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);
});