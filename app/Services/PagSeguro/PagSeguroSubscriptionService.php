<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\Request\PlanDTO;
use App\Data\PagSeguro\Response\SimpleResponseDTO;
use App\Enums\HttpMethodEnum;
use App\Models\Plan;

class PagSeguroSubscriptionService
{
    private string $baseUrl;
    private PagSeguroApiService $api;

    public function  __construct() {
        $this->baseUrl = env('PAGSEGURO_API_SUBSCRIPTION_BASE_URL', '').'/subscriptions';
        $this->api = new PagSeguroApiService();
    }
} 