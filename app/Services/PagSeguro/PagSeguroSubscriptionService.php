<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\Request\SubscriptionDTO;
use App\Data\PagSeguro\Response\SubscriptionInvoicesResponseDTO;
use App\Data\PagSeguro\Response\SubscriptionResponseDTO;
use App\Enums\HttpMethodEnum;
use App\Models\Subscription;

class PagSeguroSubscriptionService
{
    private string $baseUrl;
    private PagSeguroApiService $api;

    public function  __construct() {
        $this->baseUrl = env('PAGSEGURO_API_SUBSCRIPTION_BASE_URL', '').'/subscriptions';
        $this->api = new PagSeguroApiService();
    }

    public function create(Subscription $subscription): Subscription {
        $body = SubscriptionDTO::fromModel($subscription)->toArray();
        $response = $this->api->request($this->baseUrl, HttpMethodEnum::POST, $body, SubscriptionResponseDTO::class);

        $subscription->update([
            'bank_gateway_id' => $response->id
        ]);

        $subscription->provider->user()->update([
            'bank_gateway_id' => $response->customer->id
        ]);

        return $subscription;
    }

    public function show(Subscription $subscription): SubscriptionResponseDTO {
        $body = [];
        $response = $this->api->request($this->baseUrl.'/'.$subscription->bank_gateway_id, HttpMethodEnum::GET, $body, SubscriptionResponseDTO::class);

        return $response;
    }

    public function invoices(Subscription $subscription): SubscriptionInvoicesResponseDTO {
        $body = [];
        $response = $this->api->request($this->baseUrl.'/'.$subscription->bank_gateway_id.'/invoices', HttpMethodEnum::GET, $body, SubscriptionInvoicesResponseDTO::class);

        return $response;
    }

    public function showComplete(Subscription $subscription): SubscriptionResponseDTO {
        $response = $this->show($subscription);
        $subscriptionInvoices = $this->invoices($subscription);

        $response->invoices = $subscriptionInvoices->invoices;

        return $response;
    }
} 