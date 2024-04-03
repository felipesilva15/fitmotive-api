<?php

namespace App\Data\System;

/**
 * @OA\Schema(
 *      schema="ApiErrorDTO",
 *      @OA\Property(property="code", type="string", example="EXCPHAND001"),
 *      @OA\Property(property="endpoint", type="string", example="api/endpoint"),
 *      @OA\Property(property="message", type="string", example="Ocorreu um erro.")
 * )
 */
class ApiErrorDTO
{
    private $code;
    private $endpoint;
    private $message;

    public function __construct($code, $message, $endpoint) 
    {
        $this->code = $code;
        $this->endpoint = $endpoint;
        $this->message = $message;
    }

    public function getCode(): string 
    {
        return (string) $this->code;
    }

    public function getEndpoint(): string 
    {
        return (string) $this->endpoint;
    }

    public function getMessage(): string 
    {
        return (string) $this->message;
    }

    public function toArray(): array {
        return [
            "code" => $this->getCode(),
            "endpoint" => $this->getEndpoint(),
            "message" => $this->getMessage(),
        ];
    }
}