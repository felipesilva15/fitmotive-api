<?php

use App\Data\PagSeguro\Request\OrderDTO;
use App\Data\PagSeguro\Request\SubscriptionDTO;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChargeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\FinancialTransactionController;
use App\Http\Controllers\PagSeguroOrderController;
use App\Http\Controllers\PagSeguroPlanController;
use App\Http\Controllers\PagSeguroSubscriberController;
use App\Http\Controllers\PagSeguroSubscriptionController;
use App\Http\Controllers\SearchCepController;
use App\Http\Controllers\SubscriptionController;
use App\Models\Charge;
use App\Models\Subscription;
use App\Models\User;
use App\Services\PagSeguro\PagSeguroSubscriberService;
use Illuminate\Support\Facades\Route;
use App\Enums\PaymentMethodTypeEnum;

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

// Plan
Route::get('/plan', [PlanController::class, 'index']);
Route::get('/plan/{id}', [PlanController::class, 'show']);

Route::group(['middleware' => 'auth:api'], function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Plan
    Route::post('/plan', [PlanController::class, 'store']);
    Route::put('/plan/{id}', [PlanController::class, 'update']);
    Route::delete('/plan/{id}', [PlanController::class, 'destroy']);
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
    Route::get('/provider/{id}/charges', [ProviderController::class, 'charges']);
    Route::get('/provider/{id}/financial_transactions', [ProviderController::class, 'financialTransactions']);

    // Subscription
    Route::apiResource('/subscription', SubscriptionController::class);
    Route::patch('/pagseguro/subscription/{id}/sync', [PagSeguroSubscriptionController::class, 'sync']);

    // Patient
    Route::apiResource('/patient', PatientController::class);
    Route::post('/patient/{id}/generate_charge', [PatientController::class, 'generateCharge']);

    // Charge
    Route::apiResource('/charge', ChargeController::class);
    Route::patch('/pagseguro/charge/{id}/sync', [PagSeguroOrderController::class, 'sync']);

    // Financial Transaction
    Route::apiResource('/financial_transaction', FinancialTransactionController::class);

    // Diet
    Route::apiResource('/diet', DietController::class);

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh-token', [AuthController::class, 'refresh']);
    Route::get('/me', [AuthController::class, 'me']);

    // Reports
    Route::get('/reports/financial/defaulters', [FinancialReportController::class, 'defaulters']);
    Route::get('/reports/financial/dashboard', [FinancialReportController::class, 'dashboard']);
});