<?php

namespace App\Data\PagSeguro;

class PlanDTO 
{
    private string $token_type;
    private string $access_token;
    private string $expires_in;
    private string $refresh_token;
    private string $scope;
    private string $account_id;

    public function getAccessToken(): string {
        return  (string) $this->access_token;
    }

    public function setAccessToken(string $access_token) {
        return  $this->access_token = (string) $access_token;
    }

    public function getExpiresIn(): string {
        return  (string) $this->expires_in;
    }

    public function setExpiresIn(string $expires_in) {
        return  $this->expires_in = (string) $expires_in;
    }

    public function toArray(): array {
        return get_object_vars($this);
    }
}