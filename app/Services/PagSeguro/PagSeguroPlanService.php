<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\Request\PlanDTO;
use App\Data\PagSeguro\Response\SimpleResponseDTO;
use App\Enums\HttpMethodEnum;
use App\Models\Plan;

class PagSeguroPlanService
{
    private string $baseUrl;
    private PagSeguroApiService $api;

    public function  __construct() {
        $this->baseUrl = env('PAGSEGURO_API_SUBSCRIPTION_BASE_URL', '').'/plans';
        $this->api = new PagSeguroApiService();
    }

    public function create (Plan $plan) {
        $body = PlanDTO::fromPlan($plan)->toArray();
        $response = $this->api->request($this->baseUrl, HttpMethodEnum::POST, $body, SimpleResponseDTO::class);

        $plan->update([
            'bank_gateway_id' => $response->id
        ]);

        return $plan;
    }
} 