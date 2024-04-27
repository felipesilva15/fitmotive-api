<?php

namespace App\Data\ViaCep;

use Spatie\DataTransferObject\Attributes\MapFrom;
use Spatie\DataTransferObject\DataTransferObject;

class AddressDTO extends DataTransferObject
{
    #[MapFrom('cep')]
    public string $postal_code;
    #[MapFrom('logradouro')]
    public string $street;
    #[MapFrom('bairro')]
    public string $locality;
    #[MapFrom('localidade')]
    public string $city;
    #[MapFrom('uf')]
    public string $region_code;
}