<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\Response\TokenDTO;
use App\Enums\HttpMethodEnum;

class PagSeguroService
{
    private string $baseUrl;
    private string $connectBaseUrl;
    private string $clientId;
    private string $clientSecret;
    private string $authRedirectUri;
    private string $scopes;
    private PagSeguroApiService $apiService;

    public function  __construct() {
        $this->baseUrl = env('PAGSEGURO_API_BASE_URL', '');
        $this->connectBaseUrl = env('PAGSEGURO_API_CONNECT_BASE_URL', '');
        $this->clientId = env('PAGSEGURO_API_CLIENT_ID', '');
        $this->clientSecret = env('PAGSEGURO_API_CLIENT_SECRET', '');
        $this->authRedirectUri = env('PAGSEGURO_API_CONNECT_REDIRECT_URI', '');
        $this->scopes = env('PAGSEGURO_API_SCOPES', '');
        $this->apiService = new PagSeguroApiService();
    }

    public function getConnectAuthorizationUri() {
        $url = "{$this->connectBaseUrl}/oauth2/authorize?response_type=code&client_id={$this->clientId}&redirect_uri={$this->authRedirectUri}&scope={$this->scopes}";

        return $url;
    }

    public function generateToken(string $code): void {
        $token = $this->requestToken($code);
        $this->saveToken($token);
    }

    public function requestToken(string $code): TokenDTO {
        $url = "{$this->baseUrl}/oauth2/token";
        $data = [];

        $response = $this->apiService->request($url, HttpMethodEnum::POST, $data, TokenDTO::class);

        return $response;
    }

    private function saveToken(TokenDTO $tokenData): void {

    }
} 