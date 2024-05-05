<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\Request\PlanDTO;
use App\Data\PagSeguro\Request\SubscriptionDTO;
use App\Data\PagSeguro\Response\SimpleResponseDTO;
use App\Enums\HttpMethodEnum;
use App\Models\Plan;
use App\Models\Subscription;

class PagSeguroSubscriptionService
{
    private string $baseUrl;
    private PagSeguroApiService $api;

    public function  __construct() {
        $this->baseUrl = env('PAGSEGURO_API_SUBSCRIPTION_BASE_URL', '').'/subscriptions';
        $this->api = new PagSeguroApiService();
    }

    public function create(Subscription $subscription) {
        $body = SubscriptionDTO::fromModel($subscription)->toArray();
        $response = $this->api->request($this->baseUrl, HttpMethodEnum::POST, $body, SimpleResponseDTO::class);

        $subscription->update([
            'bank_gateway_id' => $response->id
        ]);

        return $subscription;
    }
} 