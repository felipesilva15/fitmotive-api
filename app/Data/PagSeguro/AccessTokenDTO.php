<?php

namespace App\Data\PagSeguro;

use Spatie\DataTransferObject\DataTransferObject;

class AccessTokenDTO extends DataTransferObject
{
    public string $token_type;
    public string $access_token;
    public string $expires_in;
    public string $refresh_token;
    public string $scope;
    public string $account_id;
}