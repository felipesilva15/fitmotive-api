<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\AccessTokenDTO;
use App\Data\PagSeguro\AmountDTO;
use App\Data\PagSeguro\ErrorDTO;
use App\Enums\CurrencyEnum;
use App\Exceptions\ExternalToolErrorException;
use Illuminate\Support\Facades\Http;

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

    public function getAccessToken(string $code) {
        $url = "{$this->baseUrl}/oauth2/token";
        $data = [];
        $token = '123';

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
            'X_CLIENT_SECRET' => '',
            'X_CLIENT_SECRET' => ''
        ])->acceptJson()->post($url, $data);

        if (!$response->successful()) {
            $data = [];

            foreach ($response->json()['error_messages'] as $error) {
                array_push($data, new ErrorDTO($error));
            }

            throw new ExternalToolErrorException();
        }

        $accessTokenDTO = new AccessTokenDTO($response->json());

        return $accessTokenDTO;
    }

    private function setAccessToken() {

    }
} 