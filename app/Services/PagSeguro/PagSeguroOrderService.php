<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\Request\OrderDTO;
use App\Data\PagSeguro\Response\SimpleResponseDTO;
use App\Enums\HttpMethodEnum;
use App\Models\Charge;

class PagSeguroOrderService
{
    private string $baseUrl;
    private PagSeguroApiService $api;

    public function  __construct() {
        $this->baseUrl = env('PAGSEGURO_API_BASE_URL', '').'/orders';
        $this->api = new PagSeguroApiService();
    }

    public function create(Charge $charge) {
        $body = OrderDTO::fromModel($charge)->toArray();
        $response = $this->api->request($this->baseUrl, HttpMethodEnum::POST, $body, SimpleResponseDTO::class);

        $charge->update([
            'bank_gateway_id' => $response->id
        ]);

        return $charge;
    }
} 