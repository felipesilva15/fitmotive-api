<?php

namespace App\Services\ViaCep;

use App\Data\ViaCep\AddressDTO;
use App\Exceptions\CustomValidationException;
use App\Exceptions\ExternalToolErrorException;
use Illuminate\Support\Facades\Http;

class SearchCepService
{
    public function __construct() { }

    public static function getAddressByCep(string $cep): AddressDTO {
        if (!$cep || strlen(str_replace('-', '', $cep)) < 8 || strlen(str_replace('-', '', $cep)) > 8) {
            throw new CustomValidationException('CEP inválido!');
        }

        $response = Http::retry(3, 100)->acceptJson()->get("https://viacep.com.br/ws/{$cep}/json");

        if (!$response->successful()) {
            throw new ExternalToolErrorException();
        }

        $data = $response->json();

        if (!isset($data['cep']) || !$data['cep']) {
            throw new CustomValidationException('CEP não encontrado!');
        }

        return new AddressDTO($data);
    }
}