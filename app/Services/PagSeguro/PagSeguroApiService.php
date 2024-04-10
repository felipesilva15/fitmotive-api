<?php

namespace App\Services\PagSeguro;

use App\Data\PagSeguro\Response\ErrorDTO;
use App\Enums\HttpMethodEnum;
use App\Exceptions\ExternalToolErrorException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PagSeguroApiService
{
    private string $token;
    
    public function __construct() {
        $this->token = env('PAGSEGURO_API_TOKEN', '');
    }

    public function request (string $url, HttpMethodEnum $method, array $data, string $dtoClass): mixed {
        $response = $this->makeRequest($url, $method, $data);

        if(!$response->successful()) {
            dd($response->json());
            throw new ExternalToolErrorException();
        }

        if ($dtoClass) {
            $parsedResponse = $this->parseResponse($response, $dtoClass);
        } else {
            $parsedResponse = $response->json();
        }

        return $parsedResponse;
    }

    public function makeRequest(string $url, HttpMethodEnum $method, ?array $data = []): Response {
        return Http::withToken($this->token, 'Bearer')
            ->withHeaders([
                'content-type' => 'application/json'
            ])
            ->acceptJson()
            ->{$method->value}($url, $data);
    }

    public function parseResponse (Response $response, string $dtoClass): mixed {
        return new $dtoClass($response->json());
    }

    public function parseError (Response $response): array {
        $error = [];

        foreach ($response->json()['error_messages'] as $message) {
            array_push($error, new ErrorDTO($message));
        }
        
        return $error;
    }
}