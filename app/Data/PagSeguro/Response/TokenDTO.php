<?php

namespace App\Data\PagSeguro\Response;

use Spatie\DataTransferObject\DataTransferObject;

class TokenDTO extends DataTransferObject
{
    public string $token_type;
    public string $access_token;
    public string $expires_in;
    public string $refresh_token;
    public string $scope;
    public string $account_id;
}