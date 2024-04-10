<?php

namespace App\Services\PagSeguro;

class PagSeguroService
{
    private string $baseUrl;
    private string $connectBaseUrl;
    private string $clientId;
    private string $clientSecret;
    private string $authRedirectUri;
    private string $scopes;

    public function  __construct() {
        $this->baseUrl = env('PAGSEGURO_API_BASE_URL', '');
        $this->connectBaseUrl = env('PAGSEGURO_API_CONNECT_BASE_URL', '');
        $this->clientId = env('PAGSEGURO_API_CLIENT_ID', '');
        $this->clientSecret = env('PAGSEGURO_API_CLIENT_SECRET', '');
        $this->authRedirectUri = env('PAGSEGURO_API_CONNECT_REDIRECT_URI', '');
        $this->scopes = env('PAGSEGURO_API_SCOPES', '');
    }

    public function getConnectAuthorizationUri() {
        $url = "{$this->connectBaseUrl}/oauth2/authorize?response_type=code&client_id={$this->clientId}&redirect_uri={$this->authRedirectUri}&scope={$this->scopes}";

        return $url;
    }

    private function getAccessToken(string $code) {
        $url = "{$this->baseUrl}/oauth2/token";
    }

    private function setAccessToken() {

    }
} 