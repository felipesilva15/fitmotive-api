<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\Request\SubscriberDTO;
use App\Data\PagSeguro\Response\SimpleResponseDTO;
use App\Enums\HttpMethodEnum;
use App\Exceptions\ExternalToolErrorException;
use App\Models\User;

class PagSeguroSubscriberService
{
    private string $baseUrl;
    private PagSeguroApiService $api;

    public function  __construct() {
        $this->baseUrl = env('PAGSEGURO_API_SUBSCRIPTION_BASE_URL', '').'/customers';
        $this->api = new PagSeguroApiService();
    }

    public function create(User $user) {
        $body = SubscriberDTO::fromModel($user)->toArray();
        $response = $this->api->request($this->baseUrl, HttpMethodEnum::POST, $body, SimpleResponseDTO::class);

        $user->update([
            'bank_gateway_id' => $response->id
        ]);

        return $user;
    }
} 