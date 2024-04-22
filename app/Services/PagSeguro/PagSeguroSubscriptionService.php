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
        $this->baseUrl = env('PAGSEGURO_API_SUBSCRIPTION_BASE_URL', '');
        $this->api = new PagSeguroApiService();
    }

    public function createPlan (Plan $plan) {
        $url = "{$this->baseUrl}/plans";
        $body = PlanDTO::fromPlan($plan)->toArray();

        $response = $this->api->request($url, HttpMethodEnum::POST, $body, SimpleResponseDTO::class);

        $plan->update([
            'bank_gateway_id' => $response->id
        ]);

        return $plan;
    }
} 